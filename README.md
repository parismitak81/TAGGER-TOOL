# TAGGER-TOOL
Online tagger system for transliterating social media text
********************************************************

USED TOOLS:
>Apache  Cassandra	:	As we attempt to design a tool that can handle big data, Cassandra database is used for this purpose.
>Python		:	The coding language used for this project is python.
>PHP		:	The web interface creation is carried out using PHP.


DATASET:
We have used a dataset containing detailed information about youtube videos saved as JSON files. A few files from the dataset have been included in this folder.
JSON, or JavaScript Object Notation, is a minimal, readable format for structuring data. It is used primarily to transmit data between a server and web application, as an alternative to XML.


Extracting data from the JSON files:
***********************************
According to our requirement we extract the data containing video id, date and time of publishing the video, comment id and comment; also taking into account each reply comment as a seperate, unique comment respectively. 
The code for extracting the data from the JSON files and storing into our cassandra database has been written to PARSE_JSON_FILE.py. After extracting the data, each comment is split into several sentences, assigning each sentence a unique id for identification purpose. 


Creating the table:
******************
The code for creating the table has been written to the file CASSANDRA_TABLE.txt. The attributes taken are video id, published date and time, comment id,sentence id(generated through python code for uniquely identifying each splitted sentence), the comment and an additional coloumn for storing the translated comment. The primary key is taken to be a compound one with video id and published at being the partition key and comment id and sentence id being the clustering keys.


Creating the interface:
**********************
The codes for creating the interface have been written to the files INDEX.php, SERVER.php and RETRIEVE.php. The interface displays comments one at a time from our database and allows the user to input translated comments. The translated comments are successfully updated into our database.

 
Designing the interface:
***********************
The code for designing the interface is written to the STYLE.css file.
