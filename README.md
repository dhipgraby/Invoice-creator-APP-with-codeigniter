#Invoice creator APP in codeigniter php framework.

The purpose of this reporsitory is only to show code transparency, my own work and how the application is build.
Config files and asset folders are remove to keep this repository secure and not avaible for usage.

## Application use in [slappinvoice.com](https://slappinvoice.com) for create invoices and accounting management, easy for everyone to use. UI is very simple and intuitive, easy to undertand for people of all ages. 
### This software was created on november 2019.

[slappinvoice.com](https://slappinvoice.com)  is a invoice service software. Its base on a subscription model with 3 plans that are ajust for the need of the clients. It is upgrading and getting new features each month. Sopport and assistance is always available each and everyday.

Visit the website to know in deep about this software: [slappinvoice.com](https://slappinvoice.com)
Acess the app using credentials downbelow. Go to : [app.slappinvoice.com](https://app.slappinvoice.com)

##### You can have a free tour into the application withdout subscription only to try it. 
###### Access with a test users :
###### Email : test@gmail.com
###### Password : usertest

Normally i write my code in english but in this project is in spanish for better understanding to my clients and people who im developing together with.


# Features

* Simple Invoices
* Budget
* Proforms
* Refunds
* PDF invoce generator
* Clients management
* Users management

## App structure

This is a MVC (Model Viewer Controller) Architecture provide by codeigniter framework.
Everything is organize by "Controllers" to manage the "Views" folder and database functions on "Models".

### Controllers structure

In the controllers folder, all the controllers extend from "Libraries" that handle user access.
This libraries controllers extend from the main "MY_Controller" that contain the load of models, helpers and libraries need all around the application in core folder.
Models also extend from "MY_Model" in core folder.

#### Main Controllers  
 
 * Documento : Handle all the documents creation and edition
 * Subscriptions : Handle user subscription using Stripe payment processor
 * Configuracion : For the client account config
 * Clientes : For clients management
 * Register : Create new accounts for clients
 * Usuarios : To add extra users to client accounts

 All the other files in "Controllers" show self utility by just reading the title.
 Almost each controller that work with database, is pair to a model file with same name in the "models" folder.

 #### Views folder (html and Js logic)

 The views folder contain all the html use into the app. Also some javascript files write as php to send and receive information to the backend "controllers".

 * Register : All the views for registration, create new subscriptions and accounts
 * Recover : For recovering password and accounts
 * Subscription : Containing views for loggedin users subscription.
 * User : Here is where most of the files for user usage are. Templates, documents, profile, users etc... 
 * User/js : Contain only js files with all the logic that communicate with the backend. 


 For any question you can email me to kenneth.zambrano4@gmail.com
