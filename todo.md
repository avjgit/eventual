What needs to be done

Improve the "Eventual" project by adding user comment feature:
1) an comment is related to a specific event
2) anyone can see the comments when they open the detailed view of a single event (e.g., the address http://www.eventual.org/event/view/1 )
3) registered users are allowed to add new comments
4) administrators are allowed to edit the comments

For the i-option:
5) allow the user who created the comment to edit it as well
6) allow the user who created the comment or the administrator to delete comments
7) create a migration file which updates database by adding the new table

More technical explanation

The comments are stored in DB table "comments" with the following structure:
- id (auto incrementing number, primary key)
- comment (text field)
- event_id (integer field, will store the ID of the event the comment is related to)
- user_id (integer field, will store the ID of the user who created the event)
- created (datetime field, will store the timestamp of creation time)

You have to design a new ORM model for comments. Put it in APPPATH/classes/model/orm and name the model Model_Orm_Comment (hence, the filename must be "comment.php")

Create ORM relations
- between the new model and Model_Orm_Event. It will be similar to "agendas" relation which is already there. You will have to make changes in Model_Orm_Event, too.
- between the new model and Model_Orm_User (each user has many comments, each comment belongs to a user)

You have to modify the logics behind how the event view page (http://www.eventual.org/event/view/1)

- In the controller (APPPATH/classes/controllers/event.php), in action_view, make sure that comments are loaded from the database when you fetch event information

- In the view (APPPATH/views/event/view.php),
   - after the agenda block add a new block "Comments". Print out all the comments (and the corresponding user names, too).
   - if the user is logged in, after the list of comments, show a text area and a button "add comment" (they will have to be in a HTML FORM element, the form is targetted at http://www.eventual.org/comments/create/ ). You will also have to use a hidden field to store the event_id that is needed for saving a comment.
   - if the user is logged in, and is allowed to edit comments, add a "edit" link next to each comment which is targetted at http://www.eventual.org/comments/edit/(item id)

You have to create a new controller "Comments" which will have actions "create" and "edit".
- the "create" action receives POST data (fields "comment" and "event_id") from the event view form.
     - if the "event_id" variable is empty, it simply redirects to http://www.eventual.org/
     - if the comment text is empty, it sets a flash message (something like "Please, input comment text" ) to the event view form (concatenates "http://www.eventual.org/event/view" and the "event_id" variable)
     - if the comment is set, a new comment is created. User ID field is filled with the current user's ID (how to do it)
- the "edit" ection provides a full editing interface:
     - it expects that the GET parameter is passed, it is the ID of the comment
     - if the current user is not an administrator, the action redirects back to http://www.eventual.org/
     - if the comment exists in the database, it is loaded and a view is rendered for the client. The view displays a textarea with the current comment text inside it.
      - the view submits back to itself. When POST data is received, the database item is updated and the user is redirected back to the view form of the event.

To make the comment button available only to registered users and the edit button available to administrators, you will have to change the "simpleauth.php" file in APPPATH/config/ folder.

How to get it working

If not done yet, download and install Netbeans (from netbeans.org/downloads, pick HTML5&PHP version). Add the FuelPHP plugin to Netbeans

DONE        Install WampServer from http://www.wampserver.com/en/. Even if you are on x64 machine, you can use the 32 bit version! Install it to default c:\wamp\ folder

DONE        After installation, run WAMP and make sure that this is the Apache server you need: Wamp icon->Apache -> Service -> Test port 80. If it talks about anything else than "Apache", check this http://www.ttkalec.com/blog/resolving-yellow-wamp-server-status-freeing-up-port-80-for-apache/

DONE        Enable the "rewrite module" in WAMP: http://theranjeet.com/common/uploaded_files/product/49883606651b4089913512_rewrite_enable_product_real.png

DONE        From WampServer manager, choose "PHPMyAdmin". Create a new database "fuel_dev". Create a user with all permissions in this database. Name the user "fuel_dev" and make the password also "fuel_dev".

Create the hosts file entry 127.0.0.1  = http://www.eventual.org (If you have problems with it, use http://hostsfileeditor.codeplex.com). Make sure now www.eventual.org opens the default WAMP page.

DONE        In c:\wamp\vhosts, create two files: eventual.conf  with the following contents: ....

DOEN        Download the Eventual project from github: https://github.com/naivists/TTII_2012 (don't have GIT client: use the ZIP version: https://github.com/naivists/TTII_2012/archive/master.zip ). Extract it to c:\wamp\apps\eventual directory.

Make sure the environment variable PATH contains WampServer's PHP path (how to do it: see http://www.computerhope.com/issues/ch000549.htm; the path to add is c:\wamp\bin\php\php5.4.16)
Run cmd.exe
cd c:\wamp\apps\eventual
php oil refine migrate
Launch NetBeans, click File->Open project, select the folder c:\wamp\apps\eventual
What to submit

Create a ZIP archive from c:\wamp\apps\eventual\fuel\app\. Name this zip file [your_student_id].zip, submit this file.

This also means that all the changes you have made to application configuration will be ignored. The code will be tested in database "fuel_dev" on "localhost", the user to be used for testing is fuel_dev and its password is fuel_dev.

The code is going to be tested with PHP errors and notifications turned on.