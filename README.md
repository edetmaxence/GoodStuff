# GoodStuff
Projet GoodStuff : Site annone ou les utilisateurs peut poster leur annonce en ligne.

Equipe :
•	Sri
•	Maxence
•	Xavier
•	Ntumba 
•	Adrien

Page d'accueil avec un navbar: 
•	Home 
•	List d’annonce
•	Catégorie
•	Déposer une annonce
•	Se connecter /Deconnecter
•	Rechercher l’annoce

Sur la page home (accueil) affiche toutes les annonces
Page catégorie affiche toutes les catégories, quand on click dessous, un lien nous dirige vers une page de toutes les annonce par catégorie. 
Pagination pour limiter la liste par page
Pour déposer une annonce il faut absolument se connecter
Si l'utilisateur n'a pas un compte, il doit s'inscrire donc une page avec un formulaire d'inscription

Les formulaires:
1.	Formulaire d'inscription 
2.	Formulaire de connexion
3.	Formulaire déposer une annonce
4.	Formulaire modifier l'annonce

Page utilisateur affiche son profil, ses annonce avec bouton modifier et supprimer

Crée le projet :
symfony new --webapp goodstuff
composer require symfony/apache-pack
composer require fzaninotto/faker

symfony console doctrine:database:create 

symfony console make:entity Article
•	title: string 120 not null
•	category: int (connexion avec la table category)
•	description: text
•	phonenumber: string 13
•	image: string 255
•	created_at

symfony console make:entity Category
•	name: string 50

symfony console make:controller HomeController
symfony console make:controller AdminController
symfony console make:controller CategoryController
symfony console make:controller ArticleController
symfony console make:controller UserController

symfony console make:user
symfony console make:auth

symfony console make:form UserFormType

symfony console make:entity User
•	lastname : string 50
•	firstname : string 120
•	postcode : string 5
•	city : string 100
•	phonenumber : string 10

symfony console make:registration-form
•	pseudo 
•	email

symfony console make:migration
symfony console doctrine:migrations:migrate
symfony console d:s:u  --force
composer require orm-fixtures --dev
suprimer AppFixtures
symfony console make:fixtures ArticleFixtures

symfony console make:form ArticleFormType
composer require symfonycasts/verify-email-bundle

npm install
npm run build

