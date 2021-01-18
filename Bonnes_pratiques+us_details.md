# Bonnes pratiques

## Choix de l'équipe

- Code en anglais  
- Pratique TDD au maximum  
- Url en français  
- Utilisation de faker, un framework php permettant de générer facilement tout type de données : des noms, des numéros de téléphone, des mots de passe, etc. Et d'une librairie complémentaire FakerRestaurant permetant de génerer des noms d'aliments dans notre cas des fruits et des légumes.  
- Chaque US correspond à une branche sur GIT et le merge ne se fait qu'une fois que la story a été montré à au moins un des pairs et validé par le PO.

## Architectures du code :

Creation d'un Domain organisé comme ceci :

- Domain
  - Command
  - Query

Le dossier Domain correspond au code métier de l'application, ce dossier contient les interfaces et les classes permettant la modification des données.

Le dossier Command est le dossier où se situe le code pour modifier des données en base, ces fichiers sont de la forme Command et Handler

Le dossier Query est le dossier où se situe le code pour récupérer des données en base, ces fichiers sont de la forme Query et Handler

Pour le reste du code nous reprenons la configuration par défaut de Symfony :  

- etc
- public
- App
  - src
    - Controller
    - DataFixtures 
    - Domain
      - Command
      - Query 
    - Entity
    - Extensions
    - Form
    - Repository
    - Security
  - tests
    - Controller
    - Domain
      - Command
      - Query
    - Form 
- templates
- var

## Tests :

Notre Domain permet de mieux tester notre code métier avec des tests unitaires.
On test aussi nos formulaires à l'aide de TypeTestCase.
On test aussi l'affichage de nos controller a l'aide de WebTestCase.

# US expliquées par chacun :

>  Chacun des membres de l'équipe fait le choix d'une US traitée et explicite le découplage mis en oeuvre (diagramme de classes de conception + explications) + la mise en place de test

## Louis GUILLET Z3 :

### <u> User Story choisie :</u> En tant qu'utilisateur je veux pouvoir avoir accès à une page permettant de voir les informations de mon compte et les modifier.

L'objectif de cette story est que n'importe quel utilisateur puisse voir les informations qu'il fournit au site, et les modifier à sa guise, y compris son mot de passe.

Cette story est basé sur l'entité User, elle touche autant les clients que les agriculteurs, elle concerne donc les 2 rôles (ROLE_USER, ROLE_PRODUCER).

Il y a 2 vues pour correspondre à cette US, une première qui affiche les informations données par l'utilisateur et une seconde qui est un formulaire qui permet de modifier les données enregistrées dans la base de données. La seconde vue est accessible par un bouton "Modifier le profil" présent sur la première. Qui est quant à elle accessible seulement lorsqu'un utilisateur est connecté grâce à un menu "Profil" en haut à droite de la navbar.

#### Controller

Le controller lié à ces 2 vues retourne donc ces dernières si il recoit les routes "/profil" et "/profil/modif-profil" et permet aussi de réagir lorsque tous les champs du formulaire de modification sont complétés.

Les deux fonctions du controller renverront un objet de type Response.

Pour la page de modification le controller prend en paramètre tout ce qu'il faut pour enregistrer un nouvel utilisateur, en effet l'utilisateur ne peut modifier son id, donc au moment où on le persist en base de données, cela modifie seulement ses anciennes informations sans créer de nouvel utilisateur, plutôt pratique !

Le controller prend donc en paramètres la requête, l'encodeur de mot de passe, l'handler qui permet d'enregister un utilisateur et un slugger qui transforme une chaîne donnée en une autre chaîne qui ne comporte que des caractères ASCII plus sûrs pour les URLs ou nom de fichiers/chemin, etc..

Code du formulaire :

```php=
 /**
 * @param FormBuilderInterface $builder
 * @param array $options
 */
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        ->add('firstName', TextType::class, ['label' => 'Prénom'])
        ->add('lastName', TextType::class, ['label' => 'Nom'])
        ->add('username', TextType::class, ['label' => "Nom d'utilisateur"])
        ->add('email', EmailType::class, ['label' => 'Email'])
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options' => ['label' => 'Nouveau mot de passe'],
            'second_options' => ['label' => 'Confirmer le mot de passe']
        ])
        ->add('address', TextType::class, ['label' => 'Adresse'])
        ->add('imageFile', FileType::class, [
            'label' => 'Image du profil',
            'mapped' => false,
            'required' => false,
            'constraints' => new Image([
                'maxSize' => '5M'
            ])
        ])
    ;
}

/**
 * @param OptionsResolver $resolver
 */
public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults([
        'data_class' => User::class,
    ]);
}
```

Code du Controller :

```php=
/**
 * @Route("/profil/modif-profil", name="modif-profil")
 * @param Request $request
 * @param UserPasswordEncoderInterface $passwordEncoder
 * @param RegisterHandler $handler
 * @param SluggerInterface $slugger
 * @return Response
 */
public function modif(Request $request,
                      UserPasswordEncoderInterface $passwordEncoder,
                      RegisterHandler $handler,
                      SluggerInterface $slugger): Response
{
    $user = $this->getUser();
    $form = $this->createForm(ModifyProfilType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid())
    {
        $file = $form->get('imageFile')->getData();
        if ($file)
        {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
            // Move the file to the directory where brochures are stored
            try
            {
                $file->move(
                    $this->getParameter('users_directory'),
                    $newFilename
                );
            } catch (FileException $e)
            {
            }

            $path = $path = "uploads/users/" . $newFilename;

            $img = Image::make($path)->resize(250, 250)->save();


            $user->setProfilImage($path);
        } else
        {
            $user->setProfilImage('https://bootdey.com/img/Content/avatar/avatar7.png');
        }
        $password = $passwordEncoder->encodePassword($user, $user->getPassword());
        $user->setPassword($password);

        $command = new RegisterCommand($user);
        $handler->handle($command);

        $this->addFlash('success', 'Votre compte à bien été modifié.');
        return $this->redirectToRoute('profil');

    }
    return $this->render('profil/modif.html.twig', [
        'user' => $this->getUser(),
        'form' => $form->createView()
    ]);
}

/**
 * @Route("/profil", name="profil")
 * @return Response
 */
public function index(): Response
{
    return $this->render('profil/profil.html.twig', [
        'user' => $this->getUser()
    ]);
}
```

#### Fonctionnement de l'US :

Ensuite dans le Domain on utilisera trois classes/interfaces:

- L'interface "CatalogOfUsers"
- La command "RegisterCommand"
- L'handler "RegisterHandler"

Dans l'interface on utilise la méthode qui servira à ajouter un utilisateur :

```php=
 /**
     * @param RegisterCommand $command
     * @return mixed
     */
    public function addUser(RegisterCommand $command);
```

Cette fonction est implémenté dans le repository "UserRepository" hors du domain, il va permettre de créer des requêtes personnalisées avec Doctrine. Ici il sert à ajouter un utilisateur grâce à l'utilisation des Fixtures avec l'entityManager :

```php=
 /**
     * @param RegisterCommand $command
     * @return mixed|void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addUser(RegisterCommand $command)
    {
        $em = $this->getEntityManager();
        $em->persist($command->getUser());
        $em->flush();
    }
```

La classe Handler fait ensuite le lien entre la Command et cette fonction.

```php=
class RegisterHandler
{
    /**
     * @var CatalogOfUsers
     */
    private CatalogOfUsers $catalogOfUsers;

    /**
     * RegisterHandler constructor.
     * @param CatalogOfUsers $catalogOfUsers
     */
    public function __construct(CatalogOfUsers $catalogOfUsers)
    {
        $this->catalogOfUsers = $catalogOfUsers;
    }

    public function handle(RegisterCommand $command)
    {
        $this->catalogOfUsers->addUser($command);
    }

}
```

#### Démarche de tests :

Les tests de cette us peuvent être représentés en plusieurs parties : le test du formulaire, le test du Domain(le handler avec la command) et le test du controller.

Donc d'abord je teste la le formulaire, pour cela je teste à l'aide de la classe TypeTestCase. Le but de ce test est de simuler la complétion et l'envoi d'un formulaire et de vérifier si chaque champ est fonctionel.

```php=
class ModifProfilTypeTest extends TypeTestCase
{
    /**
     * Setup fonction fix validator problem
     */
    public function setUp(): void
    {
        parent::setUp();
        $validator = $this->createMock('\Symfony\Component\Validator\Validator\ValidatorInterface');
        $validator->method('validate')->will($this->returnValue(new ConstraintViolationList()));
        $formTypeExtension = new FormTypeValidatorExtension($validator);
        $coreExtension = new CoreExtension();

        $this->factory = Forms::createFormFactoryBuilder()
            ->addExtensions($this->getExtensions())
            ->addExtension($coreExtension)
            ->addTypeExtension($formTypeExtension)
            ->getFormFactory();
    }

    /**
     * Test form modif profil
     */
    public function test_modify_profil_type()
    {;

        $formData = [
            'firstName' => 'test',
            'lastName' => 'test',
            'username' => 'test',
            'email' => 'test@gmail.com',
            'password.first' => 'test',
            'password.second' => 'test',
            'address' => 'rue de l\'example'
        ];

        $expected = new User();
        $expected->setFirstName('test');
        $expected->setLastName('test');
        $expected->setUsername('test');
        $expected->setEmail('test@gmail.com');
        $expected->setAddress('rue de l\'example');

        $contentForm = new User();

        $form = $this->factory->create(ModifyProfilType::class, $contentForm);
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $contentForm);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            if($key!='password.first' and $key!='password.second'){
                $this->assertArrayHasKey($key, $children);
            }
        }
    }

}
```

Ensuite au niveau du Domain on test l'ajout d'un utilisateur pour cela on mock un utilisateur et on regarde si la méthode dur repository a bien été appelé :

```php=
class RegisterHandlerTest extends TestCase
{
    /**
     * Test register user
     */
    public function test_add_a_user()
    {
        $user = $this->createMock(User::class);

        $catalogOfUsers = $this->createMock(CatalogOfUsers::class);

        $handler = new RegisterHandler($catalogOfUsers);
        $command = new RegisterCommand($user);

        // Assert
        $catalogOfUsers->expects($this->once())->method("addUser");

        $handler->handle($command);

    }
}
```

Pour finir je teste le controller qui me permet de simuler la complétion du formulaire avec un utilisateur existant, ainsi que sa validation et donc de vérifier si les bonnes méthodes du controller sont appelées en fonctions de ce qui se passe :

```php=
    public function test_profil_page()
    {
        $userRepository = static::$container->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('producteur@gmail.com');

        // simulate $testUser being logged in
        $this->client->loginUser($testUser);

        $this->client->request('GET', '/profil');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test page modif-profil
     */
    public function test_modif_profil_page()
    {
        $userRepository = static::$container->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('producteur@gmail.com');

        // simulate $testUser being logged in
        $this->client->loginUser($testUser);
        $crawler = $this->client->request('GET', '/profil/modif-profil');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        //submit the form
        $form = $crawler->selectButton('Sauvegarder vos modifications')->form(array(
            'modify_profil[firstName]' => 'newFirst',
            'modify_profil[lastName]' => 'newLast',
            'modify_profil[username]' => 'newnew',
            'modify_profil[email]' => 'producteur@gmail.com',
            'modify_profil[password][first]' => '123',
            'modify_profil[password][second]' => '123',
            'modify_profil[address]' => 'newAdress',
            'modify_profil[imageFile]' => $testUser->getProfilImage()
        ));

        $this->client->submit($form);
        $this->assertEquals('App\Controller\ProfilController::modif', $this->client->getRequest()->attributes->get('_controller'));

        //test the validation of form
        $this->client->followRedirect();
        $this->assertEquals('App\Controller\ProfilController::index', $this->client->getRequest()->attributes->get('_controller'));
    }
```

## Nicolas FIDEL Z3 :

### <u> User Story choisie :</u> En tant que consommateur je veux rechercher un produit a partir de la page qui liste les produits.

Le but de cette story est de pouvoir utiliser un système de recherche sur le site, pour avoir de meilleurs résultats nous allons utiliser une recherche full text.

La recherche va se baser sur l'entité Product. Pour implémenter la recherche full text nous allons ajouter un index à la classe Product

A l'aide de l'annotation suivante : 

```php=
indexes={@ORM\Index(columns={"name", "description"}, flags={"fulltext"})}
```

Notre vue sera constituée d'un formulaire de recherche et d'un résultat correspondant à cette recherche. Si la recherche ne renvoie rien l'affichage sera différent.

#### Controller

Le but du Controller est d'avoir un formulaire et quand on le complète, on affiche le résultat sur la même page.

Le Controller prend en paramètre la recherche, l'objet Request de Symfony, et le SearchProductHandler.

Ce Controller renverra un objet de type Response.

Le formulaire contiendra juste un champ 'content'.

Code du formulaire :

```php=
public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextType::class)
        ;
    }
```

Code du Controller :

```php=
 public function searchWithParam($param, Request $request, SearchProductHandler $handler): Response
    {

        // Création du formulaire
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        // Quand le formulaire est envoyé
        if ($form->isSubmitted() && $form->isValid())
        {
            // On récupère les saisies
            $content = $form->getData()["content"];

            // On redirige vers la même route
            return $this->redirectToRoute('searchParam', ['param' => $content]);
        }

        // On crée la query du Domain
        $query = new SearchProductQuery($param);

        // On récupère la liste des produits liés à cette recherche
        $products = $handler->handle($query);


        // On retourne la liste des produits, le formulaire et le contenu de la recherche
        return $this->render('search/searchResult.html.twig', [
            'products' => $products,
            'param' => $param,
            'form' => $form->createView()
        ]);
    }
```

#### Domain

Le Domain pour cette US est en trois parties:

- L'interface avec la méthode de recherche
- La Query 
- Le Handler

Dans l'interface CatalogOfProducts on ajoute la fonction searchProduct

```php=
    /**
     * return mixed
     */
    public function searchProduct(SearchProductQuery $query);
```

La classe de repository de Symfony implémentera par la suite la fonction search product.

La classe Query va représenter la requête, elle aura comme attribut une chaine de caractère qui sera le contenu que l'utilisateur devra rentrer dans le formulaire.

```php=
class SearchProductQuery
{
    /**
     * @var string
     */
    private string $keyWord;

    /**
     * SearchProductQuery constructor.
     * @param string $keyWord
     */
    public function __construct(string $keyWord)
    {
        $this->keyWord = $keyWord;
    }
}
```

La classe Handler fera le lien entre la Query et la fonction de l'interface.

```php=
class SearchProductHandler
{
    /**
     * @var CatalogOfProducts
     */
    private CatalogOfProducts $catalogOfProduct;

    /**
     * SearchProductHandler constructor.
     * @param CatalogOfProducts $aCatalogOfProducts
     */
    public function __construct(CatalogOfProducts $aCatalogOfProducts)
    {
        $this->CatalogOfProducts = $aCatalogOfProducts;
    }

    /**
     * @param SearchProductQuery $query
     * @return mixed
     */
    public function handle(SearchProductQuery $query)
    {
        return $this->CatalogOfProducts->searchProduct($query);
    }
}
```

La partie Domain nous permet plus d'abstraction, de séparer notre code métier, avoir du php pure et indépendant de Symfony (ce qui simplifirait un changement de Framework ou une ootentielle nouvelle release de Symfony).

Le Domain est aussi plus facilement testable.

### Repository (implémentation du Domain)

Le Repository va permettre de créer des requêtes personnalisées avec Doctrine.

Nous allons utiliser la classe ProductRepository qui va implémenter l'interface CatalogOfProducts.

Pour permettre la requête fullText avec Doctrine j'ai ajouté une extension de ce dernier trouvée sur internet.

Dans cette fonction nous allons exécuter une requête SQL visant à faire une recherche FullText sur les noms et les descriptions des produits.

```php=
public function searchProduct(SearchProductQuery $query)
    {
        return $this->createQueryBuilder('p')
            ->where('MATCH_AGAINST(p.name, p.description) AGAINST(:param boolean)> 0.05')
            ->setParameter('param', $query->getKeyWord())
            ->getQuery()
            ->getResult();
    }
```

#### Démarche de tests:

Pour diviser les tests en plusieurs parties, je les ai séparé en trois catégories :

- le test du formulaire 
- le test du Domain
- le test du Controller

**Test Formulaire :**

En premier lieu je teste le formulaire, pour cela j'utilise la classe TypeTestCase. Le but de ce test est de simuler la complétion et l'envoi d'un formulaire.

```php=
class SearchTypeTest extends TypeTestCase
{
    /**
     * Test form search
     */
    public function test_search_type()
    {
        $formData = [
            'content' => 'test'
        ];

        $form = $this->factory->create(SearchType::class);
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($form->getData()["content"], "test");

    }
}
```

**Test Domain(handler) :**

Pour tester le Domain je mock ma Query, mon Handler et mon catalog de produit.

Je verifie que lorque que l'on appelle la méthode Handle que la fonction searchProduct s'execute qu'une seule fois.

```php=
class SearchProductHandlerTest extends TestCase
{
    /**
     * Test search handler
     */
    public function test_obtain_the__list_of_products_search()
    {

        // Arrange
        $query = $this->createMock(SearchProductQuery::class);
        $catalog = $this->createMock(CatalogOfProducts::class);
        $handler = new SearchProductHandler($catalog);

        // Assert
        $catalog->expects($this->once())->method("searchProduct");

        // Act
        $listProducts = $handler->handle($query);
    }
}
```

**Test Controller :**

Maintenant je vais tester mon Controller dans ce test je vérifie que mon controller rend une vue avec un code HTTP 200.

J'aurais pu tester un peu plus la page a l'aide de crawler qui permet de chercher si les éléments sont sur la page mais je n'est pas trouvé cela pertinant dans ce cas.

```php=
    /**
     * Test search page
     */
    public function test_search_page()
    {
        $this->client->request('GET', '/search/test');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
```

## Mathis DEVIGNE Z3 :

### <u> User Story choisie</u> : En tant qu'utilisateur je souhaite remplir un formulaire de contact.

Cette story a pour objectif de permettre à un utilisateur, connecté ou non, de remplir un formulaire de contact pour pouvoir envoyer un message aux gérants du site web. Le formulaire enverra les informations dans la base de données.

Pour cette story, j'ai dû créer l'entity Message pour pouvoir récuperer les informations transmises. Elle est donc composée du texte, de l'objet et de l'email (string[255]).

Cette US a une vue affichant un formulaire simple de contact et un bouton d'envoi à la base de données, elle est accessible depuis le footer en cliquant sur la rubrique "Contact".

#### Controller

Le controller de l'US permet retourner la vue lorsqu'il reçoit la route /contact. Il a aussi pour but d'envoyer les informations rentrée quand le formulaire est rempli est que le bouton est appuyé.

Pour la page de contact, La fonction index du controller prend en paramètres une requête de type Request et un ContactFormHandler pour enregistrer les informations du fomulaire. Elle renverra un objet de type Response.

Code du formulaire : 

```php=
//ContactType.php

/**
 * @param FormBuilderInterface $builder
 * @param array $options
 */
public function buildForm(FormBuilderInterface $builder, array $options){
    $builder
        ->add('object', TextType::class, ['label' => 'Objet'])
        ->add('email', TextType::class, ['label' => 'Adresse email'])
        ->add('text', TextareaType::class, ['label' => 'Veuillez écrire votre message']);
}
```

Code du controller :

```php=
//ContactController.php

/**
 * @Route("/contact", name="Nous contacter")
 */
public function index(Request $request, ContactFormHandler $handler): Response
{
    $message = new Message();

    // Création du formulaire
    $form = $this->createForm(ContactType::class, $message);
    $form->handleRequest($request);


    // Si formulaire envoyé
    if ($form->isSubmitted() && $form->isValid()) {
        $this->addFlash('success', 'Votre message à bien été envoyé.');
        $command = new ContactFormCommand($message);
        $handler->handle($command);
    }

    // Retour du message et du formulaire
    return $this->render('contact/index.html.twig', [
        'message' => $message,
        'form' => $form->createView()
    ]);
}
```

#### Domain

Le Domain de l'US est composé de deux classes et une interface :

- Une interface (CatalogOfMessages)
- Une Command (ContactFormCommand)
- Un Handler (ContactFormHandler)

Dans l'interface la méthode pour ajouter un message à la base de donnée est utilisée :

```php=
//CatalogOfMessages.php

    /**
     * @param ContactFormCommand $command
     * @return mixed
     */
    public function addMessage(ContactFormCommand $command);
```

La Command est composée d'un attribut de type Message, d'un constructeur, d'un getter et d'un setter pour permettre la modification de l'attribut.

```php=
//ContactFormCommand.php

    /**
    * @var Message
    */
    private Message $message;

    /**
     * AddSubscriberCommand constructor.
     * @param $message
     */
    public function __construct(Message $message){
        $this->message = $message;
    }

    /**
     * @return Message
     */
    public function getMessage(): Message{
        return $this->message;
    }

    /**
     * @param Message $message
     */
    public function setMessage(Message $message): void{
        $this->message = $message;
    }
```

Le Handler permet de faire le lien avec la Command et la fonction addMessages du repository.

```php=
//ContactFormHandler.php

    /**
     * @var CatalogOfMessages
     */
    private CatalogOfMessages $catalogOfMessages;

    /**
     * RegisterHandler constructor.
     * @param CatalogOfMessages $catalogOfMessages
     */
    public function __construct(CatalogOfMessages $catalogOfMessages){
        $this->catalogOfMessages = $catalogOfMessages;
    }

    /**
     * @param ContactFormCommand $command
     */
    public function handle(ContactFormCommand $command){
        $this->catalogOfMessages->addMessage($command);
    }
```

#### Repository

Nous allons prendre un Repository nomé MessageRepository pour pouvoir avoir des requêtes personnalisées avec Doctrine (Ici ajouter un Message). 
Pour l’ajout d'un Message à la base de données, le repository persist et flush le message de la Command rentrée en paramètre à l'aide d'un EntityManager.

```php=
//MesssageRepository.php

    /**
     * @param ContactFormCommand $command
     * @return mixed|void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addMessage(ContactFormCommand $command)
    {
        $em =  $this->getEntityManager();
        $em->persist($command->getMessage());
        $em->flush();
    }
```

#### Démarche de test

Pour tester cette US, il faut que les tests effectués voient si : 

- Le formulaire renvoie bien les bonnes informations
- Le Handler appelle bien la fonction pour ajouter le message
- Le Controller renvoie bien la vue

On commence par tester le formulaire à l'aide de TypeTestCase :
On lui fait simuler une complétion (lignes 8-12), puis un envoi (ligne 22) et on voit si ça correspond avec ce que l'on attendait.

```php=
//ContactTypeTest

    /**
     * Test contact form
     */
    public function test_contact_type()
    {
        $formData = [
            'email' => 'test',
            'object' => 'test',
            'text' => 'test',
        ];

        $expected = new Message();
        $expected->setText('test');
        $expected->setObject('test');
        $expected->setEmail('test');

        $contentForm = new Message();

        $form = $this->factory->create(ContactType::class, $contentForm);
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $contentForm);
    }
```

On teste ensuite l'Handler à l'aide de TestCase :
On lui fait mock deux objets, un de type Message et l'autre de type CatalogOfMessages, puis on crée un ContactFormHandler et un ContactFormCommand.
On teste également si la fonction appelée correspond à la fonction attendue.

```php=
//ContactFormHandlerTest

    /**
     * Test messages add
     */
    public function test_add_a_message()
    {
        $message = $this->createMock(Message::class);

        $catalogOfMessages = $this->createMock(CatalogOfMessages::class);

        $handler = new ContactFormHandler($catalogOfMessages);
        $command = new ContactFormCommand($message);

        // Assert
        $catalogOfMessages->expects($this->once())->method("addMessage");

        $handler->handle($command);

    }
```

Pour finir nous testons le Controller à l'aide de TypeTestCase :

```php=
//ContactControllerTest

    public function test_contact_form()
        {;
            $formData = [
                'email' => 'test@test.test',
                'object' => 'test',
                'text' => 'test'
            ];

            $expected = new Message();
            $expected->setEmail('test@test.test');
            $expected->setObject('test');
            $expected->setText('test');

            $contentForm = new Message();

            $form = $this->factory->create(ContactType::class, $contentForm);
            $form->submit($formData);
            $this->assertTrue($form->isSynchronized());
            $this->assertEquals($expected, $contentForm);

            $view = $form->createView();
            $children = $view->children;

            foreach (array_keys($formData) as $key) {
                $this->assertArrayHasKey($key, $children);
            }
    }
```

## Mathieu LUCAS Z3 :

### <u> User Story choisie</u> : En tant que producteur je veux pouvoir modifier les attributs d'un produits

Le but de cette story est de permettre à un producteur connecté la modification d'un produit, préalablement ajouté bien évidemment, depuis sa page contenant ses produits.
<br>
Pour qu'un producteur modifie un de ses produits il doit donc accéder à la liste de ses produits, sur cette page ses produits auront un bouton "modifier le produit" qui redirigera vers la page de modification du produit.

Cette page contient un formulaire identique à celui utilisé pour l'ajout d'un produit exepté le fait que les placeholders contiendra les informations actuelles du produit.

#### Controller

Pour ce qui est du Controller, on possède une route qui est déterminée par l'id produit. Cette ID correspond à l'id généré automatiquement par doctrine, il est passé en paramètre et sert afin de récupérer le produit correspondant via le handler "OneProductHandler", produit qui sera aussi renvoyé à la page générée. Le formulaire renvoyé se basera donc sur ce produit. Une fois le formulaire modifié par appui sur un bouton,  ce sera le handler "addProductHandler" qui sera appelé, puis le producteur sera redirigé vers la page "mesproduits".

```php=
    /**
     * @Route("/admin/produits/mesproduits/{id}", name="ModifProduct")
     * @param $id
     * @return Response
     */
public function modificationOfMyProduct(Request $request, OneProductHandler $handler, $id, AddProductHandler $Addhandler, Security $security, SluggerInterface $slugger): Response
    {
        $query = new OneProductQuery();
        $product = $handler->handle($query, $id);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $file = $form->get('imageFile')->getData();
            if ($file)
            {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
                // Move the file to the directory where brochures are stored
                try
                {
                    $file->move(
                        $this->getParameter('products_directory'),
                        $newFilename
                    );
                } catch (FileException $e)
                {
                }

                $path = "uploads/products/" . $newFilename;
                // Resize image
                $img = Image::make($path)->resize(250, 250)->save();


                $product->setSourceImage($path);
            } else
            {
                $product->setSourceImage('https://via.placeholder.com/150/93A8AC/000000?Text=FarMeetic');
            }


            $product->setProducers($security->getUser());
            $command = new AddProductCommand($product);
            $Addhandler->handle($command);

            return $this->redirectToRoute('mesproduits');
        }


        return $this->render('products/admin/ModifProduct.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }
```

#### Domain

Le handler permettant la recherche et la récupération d'un produit via son id.

```php=
class OneProductHandler
{
    private $catalog;

    public function __construct(CatalogOfProducts $aCatalogOfProducts)
    {
        $this->catalog=$aCatalogOfProducts;
    }

    public function handle(OneProductQuery $query, $id): \App\Entity\Product
    {
        return $this->catalog->find($id);
    }
}
```

Command pour les produits.

```php=
class AddProductCommand
{
    /**
     * @var Product
     */
    private Product $product;

    /**
     * AddProductCommand constructor.
     * @param $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

}
```

Handler permettant l'appel de la méthode du repository, pour l'ajout d'un produit.

```php=
class AddProductHandler
{

    /**
     * @var CatalogOfProducts
     */
    private CatalogOfProducts $catalogOfProducts;

    /**
     * AddProductHandler constructor.
     * @param CatalogOfProducts $catalogOfProducts
     */
    public function __construct(CatalogOfProducts $catalogOfProducts)
    {
        $this->catalogOfProducts = $catalogOfProducts;
    }

    /**
     * @param AddProductCommand $command
     */
    public function handle(AddProductCommand $command)
    {
        $this->catalogOfProducts->addProduct($command);
    }


}
```

#### Repository

Function du repository, on récupère la commande qui vient nous donner le produit qu'on vient persist puis valider dans la BD. L'utilisation du persist permet non seulement l'ajout mais aussi la modification, en effet, un produit déjà existant sera ré-actualisé via l'utilisation du persist.

```php=
    public function addProduct(AddProductCommand $command)
    {
        //dd($command->getProduct());
        $em =  $this->getEntityManager();
        $em->persist($command->getProduct());
        $em->flush();
    }
```

#### View

Pour ce qui est de l'affichage de la Vue, et plus précisément du form, on a un simple affichage avec nos placeholders, la seule spécificité est que les placeholders contiennent les informations actuelles du produit.

```htmlmixed=
 <form method="POST" enctype="multipart/form-data">
                        {{ form_start(form, {'multipart': true}) }}
                        {{ form_errors(form) }}

                        <ul class="row">
                            <li class="col-md-6">
                                <div class="input-group">
                                    <div class="col-md-10">
                                        {{ form_label(form.name) }}
                                        {{ form_widget(form.name, {'attr': {'class': 'form-control', 'placeholder': product.name}}) }}
                                    </div>
                                </div>
                            </li>
                            <li class="col-md-6">
                                <div class="input-group">
                                    <div class="col-md-10">
                                        {{ form_label(form.description) }}
                                        {{ form_widget(form.description, {'attr': {'class': 'form-control', 'placeholder': product.description}}) }}
                                    </div>
                                </div>
                            </li>
                            <li class="col-md-6">
                                <div class="input-group">
                                    <div class="col-md-10">
                                        {{ form_label(form.price) }}
                                        {{ form_widget(form.price, {'attr': {'class': 'form-control', 'placeholder': product.price}}) }}
                                    </div>
                                </div>
                            </li>

                            <li class="col-md-12">

                                {{ form_row(form.imageFile) }}

                            </li>


                            <li class="col-md-12">
                                <button class="register">Sauvegarder les changements</button>
                            </li>
                            {{ form_end(form) }}
                        </ul>
                    </form>
```

#### Test

Concernant les tests j'ai surtout fait un test sur le controller le formulaire ayant déjà été testé. Ce test a pour but de vérifier la bonne connexion à la page de modification d'un produit
Pour se faire, on récupère tout les utilisateurs pour ensuite utiliser la méthode "findOneByEmail" afin de trouver le producteur qui nous intéresse( le find n'est pas utilisé du fait qu'il se base sur un id généré aléatoirement par Doctrine, et que je n'ai pas pensé à faire le changement ou du moins trop tard ).On connecte cet utilisateur, récupère ses produits et on vérifie la connexion au premier produit de sa liste. 

```php=
public function test_modification_of_a_product_of_a_producer()
    {
        $userRepository = static::$container->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('karim.boulgour@farm.com');

        // simulate $testUser being logged in
        $this->client->loginUser($testUser);

        $products = $testUser->getProducts();

        $this->client->request('GET', '/admin/produits/mesproduits/'. $products[0]->getId());
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
```

## Rémi MIGNON Z3

### <u> User Story choisie</u> : En tant qu'utilisateur quand je m'inscrit a la newsletter je reçois un email de confirmation

Pour cette story il nous faut donc le moyen de s'inscrire à une newsletter et d'envoyer un mail de confirmation à cette inscription.

/!\ On peut s'inscrire à la newsletter sans avoir de compte sur le site. /!\

Pour envoyer des mails on utilise mailer que composer nous met à disposition ainsi que mailhog qui simulera la boite mail des utilisateurs.
Pour savoir qui est inscrit à la newsletter un simple table contenant les mails (unique) suffira. 

Si un utilisateur veut se désinscrire, il lui suffit de cliquer sur le lien dans les mails qu'il recoit. Le lien renvoie vers une route spécifique du site avec le mail hashé comme paramètre qui permet de retrouver le mail concerné dans la base de données pour le supprimer.

*La route /sendNewsletter permet l'envoi d'un mail pré-définis, contenant la date d'envoi, à tous les abonné de la newsletter pour savoir si le tout fonctionne. Cette route devra
être supprimée une fois qu'un moyen plus propre d'écrire et d'envoyer les newsletters sera crée*

#### Controller

L'envoi de mail ce fait avec la fonction sendEmail, qui peut être apellée par n'importe qui si il y a besoin d'envoyer un mail dans une future fonctionalité.

```php=
public function sendEmail($from,$to,$subject,$content)
{
    for ($i=0, $size = count($to); $i < $size; $i++){
        $h=hash('md5',$to[$i]);
        $email = (new Email())
            ->from($from)
            ->to($to[$i])
            ->subject($subject)
            ->html($content.'<br><p><a href="localhost:9999/newsletter/unsubscribe/'.$h.'">Vous desabonné ?</a></p>');
        $this->mailer->send($email);
    }
}  
```

Pour s'inscrie, sur la route /newsletter, le controller crée un formulaire (qui ne contient qu'un seul champ, je me suis dit que créer un objet form n'en valait pas la peine). Si l'utilisateur est connecté, le formulaire sera pré-remplis avec l'adresse mail qu'il a utilisé lors de son inscription. Un mail de bienvenue sera alors envoyé à l'adresse renseignée. Si l'adresse mail est déjà inscrite dans la base de données, l'utilisateur en sera informé.

```php=
public function subToNewsletter(Request $request,AddSubscriberHandler $handler,Security $security): Response
{
    $sub = new Subscriber();

    if($security->getUser()){
        $sub->setEmail($security->getUser()->getEmail());
    }

    $form = $this->createFormBuilder($sub)
                 ->add('email')
                 ->getForm();
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){

        $from = 'newsletter@farmeetic.com';
        $to = array($sub->getEmail());
        $subject = 'Newsletter subscription';
        $content = 'Hello, welcome to the newsletter !';
        $this->sendEmail($from,$to,$subject,$content);

        $command = new AddSubscriberCommand($sub);
        $handler->handle($command);

        return $this->redirectToRoute('home');
    }

    return $this->render('mail/newsletter.html.twig', [
        'formEmail'=>$form->createView()
    ]);
}
```

Une fois arrivé sur la route /newsletter/unsubscribe/{code}, le controller récupere le code, cherche l'adresse mail concernée, la supprime, et retourne une page indiquant que l'utilisateur a été desinscrit de la newsletter.

```php=
public function unSub(DeleteSubscriberHandler $handler,$code): Response
{
    if($handler->find($code))
    {
        $command = new DeleteSubscriberCommand($handler->find($code));
        $handler->handle($command);
    }

    return $this->render('mail/unsub.html.twig');
}
```

#### Domain

Nous utiliserons un CatalogOfSubscribers pour faire la liaison avec l'Entity et la base de données.

Les classes AddSubscriberCommand et AddSubscriberHandler permettent d'enregister le mail du nouvel abonné dans la base de données tout en permettant de faire des tests sur les fonctions qui y sont implémentées.

Les classes DeleteSubscriberCommand et DeleteSubscriberHandler sont utilisées pour se désinscrire de la newsletter.

#### Repository

Pour l'inscription, le repository ajoute, persist et flush le nouvel abonné.

```php=
public function addSubscriber(AddSubscriberCommand $command)
{
    $em =  $this->getEntityManager();
    $em->persist($command->getSubscriber());
    $em->flush();
}
```

Pour la désinscription, une fonction cherche quelle adresse mail corespond au code récuperé et le retourne pour savoir quel adresse mail doit être supprimée dans la fonction deleteSubscriber.

```php=
public function deleteSubscriber(DeleteSubscriberCommand $command)
{
    $em = $this->getEntityManager();
    $em->remove($command->getSubscriber());
    $em->flush();
}

public function findByCode($code)
{
    $subs = $this->findAll();
    foreach ($subs as &$sub){
        if($code==hash('md5',$sub->getEmail()))
        {
            return $sub;
        }
    }
}
```

#### Démarche de tests

Aucun tests poussés n'a eté fait sur cette US car je n'avais aucune idée de comment tester si les mails étaient bien envoyés.
