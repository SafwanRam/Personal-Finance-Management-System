<?php 
$conn = mysqli_connect("localhost", "root", "", "management_system");

function toCurrency($index,$a){
   return number_format($index , $a, ",", ".");
}
// Section Tabel
function query($QdataTabel){
    global $conn;
    $result = mysqli_query($conn, $QdataTabel);
    
    $rows = [];
    while( $row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}

function clean_array($array) {
    return array_map(function($nul){
      return ($nul === NULL ) ? 0 : $nul;
    }, $array);
  }
function SUM($QdataTabel){
    global $conn;
    $result = mysqli_query($conn, $QdataTabel);
    $row = mysqli_fetch_assoc($result);
    return $row;
  }

// Section Erase Data
function delete($id, $table){
    global $conn;
    mysqli_query($conn, "DELETE FROM $table WHERE id = $id");
    return mysqli_affected_rows($conn);
};
function deletUser(){
    global $conn;
    global $userActive;
    $track = strtolower($userActive);
    mysqli_query($conn, "DELETE FROM users WHERE username = '$track'");
    mysqli_query($conn, "DELETE FROM expenditure WHERE user = '$userActive'");
    mysqli_query($conn, "DELETE FROM finance WHERE user = '$userActive'");
    return mysqli_affected_rows($conn);
};

// Section Registration
function registrasi($data){
    global $conn;

    $username = strtolower(stripslashes($data["rusername"]));
    $email = $data['remail'];
    $password = mysqli_real_escape_string($conn, $data["rpassword"]);
    $password2 = mysqli_real_escape_string($conn, $data["rpassword2"]);
    $location = $data["location"];
    $Instansi = "Home Industri";

    // Section Username
    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)){
        echo "<script> alert('Username Telah Terdaftar') </script>";
        return false;
    }

    // Check Password
    if( $password !== $password2){
        echo "<script> alert('Password Tidak Sama') </script>";
        return false;
    }

    // Encryption password
    $password = password_hash($password, PASSWORD_DEFAULT);
    $account = mt_rand(1000, 9999)." ".mt_rand(1000, 9999)." ".mt_rand(1000, 9999)." ".mt_rand(1000, 9999);

    // Add a new user to the database
    mysqli_query($conn, "INSERT INTO users VALUE('', '$username', '$email', '$password','$username','', '$account', '$location', '$Instansi')");
    return mysqli_affected_rows($conn);
}

// Section Add Data Tabel
function adddataTabel($data){
    global $conn;
    global $userActive;
    $activity = htmlspecialchars($_POST["activity"]);
    $date = htmlspecialchars($_POST["date"]);
    $nominal = preg_replace("/[^0-9,()'' ]/", "", $_POST["nominal"]);
    $month = date("F", mktime(0, 0, 0, substr($date,5,2), 10));
    $year = substr($date,0,4);
    $user = $userActive;

    // Add a new user to the database
    mysqli_query($conn, "INSERT INTO expenditure VALUE('', '$date', '$activity', '$nominal', '$month', '$year','$user')");
    return mysqli_affected_rows($conn);
}

// Section add finance
function inputMoney($data){
    global $conn;
    global $userActive;
    $money = preg_replace("/[^0-9 ]/", "", $_POST["nominal"]);
    $user = $userActive;
    $activity = htmlspecialchars($_POST["activity"]);
    $date = htmlspecialchars($_POST["date"]);

    mysqli_query($conn, "INSERT INTO finance VALUE('', '$user', '$activity', '$date', '$money')");
    return mysqli_affected_rows($conn);

}

// Section Update Data Tabel
function updatedataTabel($data){
    global $conn;
    global $userActive;
    $activity = htmlspecialchars($_POST["activity"]);
    $date = htmlspecialchars($_POST["date"]);
    $nominal = preg_replace("/[^0-9 ]/", "", $_POST["nominal"]);
    $month = date("F", mktime(0, 0, 0, substr($date,5,2), 10));
    $year = substr($date,0,4);
    $id = $_POST["id"];
    $user = $userActive;

    // Add a new user to the database
    mysqli_query($conn, "UPDATE expenditure SET date = '$date', activities = '$activity', nominal = '$nominal', month ='$month', year = '$year', user = '$user' WHERE id = $id");
    return mysqli_affected_rows($conn);
}

// Section Update Data User
function updateProfile($data){
    global $conn;
    global $userActive;
    $name = htmlspecialchars($_POST["names"]);
    $email = htmlspecialchars($_POST["email"]);
    $contact = htmlspecialchars($_POST["contact"]);
    $location = htmlspecialchars($_POST["location"]);
    //$instansi = htmlspecialchars($_POST["instansi"]);
    $track = strtolower($userActive);

    // Add a new user to the database
    mysqli_query($conn, "UPDATE users SET email = '$email', name = '$name', contact ='$contact', location = '$location' WHERE users.username = '$track'");
    return mysqli_affected_rows($conn);
}

// Income activity
function incomeSave($data){
   global $conn;
   global $userActive;
   $user = $userActive;
   $activity = htmlspecialchars($_POST["activity"]);
   $date = htmlspecialchars($_POST["date"]);
   $nominal = preg_replace("/[^0-9,()'' ]/", "", $_POST["nominal"]);

   mysqli_query($conn, "INSERT INTO savings VALUE('', '$user', '$activity','$nominal', '$date')");
   return mysqli_affected_rows($conn);
}

// Spending activity
function spendsaving($data){
    global $conn;
    global $userActive;
    $money = preg_replace("/[^0-9 ]/", "", $_POST["nominal"]);
    $user = $userActive;
    $date = htmlspecialchars($_POST["date"]);
    mysqli_query($conn, "INSERT INTO savings_out VALUE('', '$user', '$money', '$date')");
    return mysqli_affected_rows($conn);
}
?>