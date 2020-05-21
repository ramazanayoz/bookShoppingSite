<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ramazan_ayoz";


// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 
// Create database
$sql = 'CREATE DATABASE  '.$dbname.' ';
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}
$conn->close();


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}




// sql to create table
$sql = "CREATE TABLE users (
    id INT(100)  AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(300) ,
    email VARCHAR(300) NOT NULL ,
    role VARCHAR(50) NOT NULL,
    password VARCHAR(5000000) NOT NULL
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Table MyGuests created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }    


        
// sql to create table
$sql = "CREATE TABLE books (
    book_id INT(100) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    book_name VARCHAR(530),
    book_category VARCHAR(230),
    author_name VARCHAR(230),
    book_page VARCHAR(230),
    book_price VARCHAR(230),
    book_brief VARCHAR(1000),
    book_picture BLOB(4000000000)    
    )";


if ($conn->query($sql) === TRUE) {
    echo "Table Ramazan_Ayoz created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}    

$conn -> close();

$connect = new PDO("mysql:host=localhost;dbname=ramazan_ayoz", "root", "");
$connect->query("SET NAMES 'utf8'");

//---------------INSERT USER
$name = "Ramazan Ayoz";
$email =  'admin';
$role = "admin";
$password = 'admin';

$Query = $connect->prepare("INSERT INTO users (name, email, role, password) VALUES (?,?,?,?)");
$Query->execute([$name, $email, $role, $password]);


//---------------INSERT USER
$name = "customer2";
$email = "admin2@gmail.com";
$role = "customer";
$password = 'admin';

$Query = $connect->prepare("INSERT INTO users (name, email, role, password) VALUES (?,?,?,?)");
$Query->execute([$name, $email, $role, $password]);

//---------------INSERT USER
$name = "customer3";
$email = "admin3@gmail.com";
$role = "customer";
$password = 'admin';

$Query = $connect->prepare("INSERT INTO users (name, email, role, password) VALUES (?,?,?,?)");
$Query->execute([$name, $email, $role, $password]);


$image = '../images/kidnapped.jpg';
// Read image path, convert to base64 encoding
$imageData = base64_encode(file_get_contents($image));

// Format the image SRC:  data:{mime};base64,{data};
$src = 'data: '.mime_content_type($image).';base64,'.$imageData;

// Echo out a sample image
//echo '<img src="' . $src . '">';
echo '<a class="active" href="../home.php"> go to Home</a>';

//---------------INSERT BOOKS
$book_name = "Kidnapped";
$book_category = "Drama";
$author_name = "Drama";
$book_page = '250';
$book_price = '25';
$book_brief = '
Because it’s better than Treasure Island and based on real people and real events. Alan Breck Stewart is a memorable character
';
$book_picture = $src;

$Query = $connect->prepare("INSERT INTO books (book_name, book_category, author_name, book_page, book_price, book_brief, book_picture) VALUES (?,?,?,?,?,?,?)");
$Query->execute([$book_name, $book_category, $author_name,  $book_page, $book_price, $book_brief, $book_picture]);

//---------------INSERT BOOKS
$book_name = "Lord of the Flies";
$book_category = "Crime";
$author_name = "Author";
$book_page = '250';
$book_price = '25';
$book_brief = '
Because it’s better than Treasure Island and based on real people and real events. Alan Breck Stewart is a memorable character
';

$Query = $connect->prepare("INSERT INTO books (book_name, book_category, author_name, book_page, book_price, book_brief, book_picture) VALUES (?,?,?,?,?,?,?)");
$Query->execute([$book_name, $book_category, $author_name,  $book_page, $book_price, $book_brief, $book_picture]);


//---------------INSERT BOOKS
$book_name = "Lorna Doone";
$book_category = "Fable";
$author_name = "Author";
$book_page = '250';
$book_price = '25';
$book_brief = '
Because it’s better than Treasure Island and based on real people and real events. Alan Breck Stewart is a memorable character
';

$Query = $connect->prepare("INSERT INTO books (book_name, book_category, author_name, book_page, book_price, book_brief, book_picture) VALUES (?,?,?,?,?,?,?)");
$Query->execute([$book_name, $book_category, $author_name,  $book_page, $book_price, $book_brief, $book_picture]);

?>