Tutorial OOP and MVC
====================

Requirements: PHP 5.2+, smarty (PHP template engine)

Description:
------------
This tutorial includes projects to show MVC pattern (Model, View, Controller) as well as OOP (Object Orientated Programming).  
Most of the logic programm-logic is simple to keep the focus on structure and general aspects of programming.  

Currently "smarty" is used as template engine, while a shift to something more modern might be expectable.
"smarty" regrettable has a small impact on the programm-logic as arrays are used for data instead of Objects.  
Nevertheless a general approach for an object-orientated template engine is partially prepared.

Installation:
=============
1) **by composer**
  --------------
  To load the project including smarty with composer use
  ```
  composer create-project wdb/tutorial-oop
  ```
  If you want to install the master-branch instead of the latest release use
  ```
  composer create-project -s dev wdb/tutorial-oop
  ```

2) **by git**
---------
git clone https://github.com/DavidBruchmann/tutorial_oop.git  
Then refer to [including smarty in manual installation](https://github.com/DavidBruchmann/tutorial_oop#including-smarty-in-manual-installation) below.

3) **by zipped release**
--------------------
Download the latest release from this page:  
https://github.com/DavidBruchmann/tutorial_oop/releases  
Then refer to [including smarty in manual installation](https://github.com/DavidBruchmann/tutorial_oop#including-smarty-in-manual-installation) below.

Including smarty in manual installation
---------------------------------------
in the downloaded project folder there has to be a folder `vendor/smarty/smarty` including the template engine.
Without using composer the download and the arrangement of the structure has to be done manually.  

Even with manual download you also still can use `composer install` to install only smarty by composer.
