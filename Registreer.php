<?php
session_start();


$firstnameErr = $lastnameErr= $email1Err = $email2Err = $psw1Err = $psw2Err = $adressErr = $postalErr = $phoneErr = $genderErr = $dateErr = "";
/* $firstname = $lastname = $email1 = $email2 = $psw1 = $psw2 = $street = $postalNr = $phone = $gender = $birthdate = "";
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ((isset($_POST["RegisterFormFirstName"]))&&(empty($_POST["RegisterFormFirstName"]))) {
        $firstnameErr = "Voornaam is vereist";
        unset($_SESSION["firstname"]);
    } else {
        $firstname = test_input($_POST["RegisterFormFirstName"]);
        if (!preg_match("/^[A-Za-z'-ÀÁÂÃÄÅÇÈÉÊËÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäèéçêëìíîïòóôõöùúûü ]*$/",$firstname)) {
            $firstnameErr = $firstname." is een ongeldige voornaam";
            unset($_SESSION["firstname"]);
        } 
        else {
          $_SESSION["firstname"] =$firstname;
        }      
    }
    
    if ((isset($_POST["RegisterFormLastName"]))&&(empty($_POST["RegisterFormLastName"]))) {
        $lastnameErr = "Naam is vereist";
        unset($_SESSION["lastname"]);
    } else {
        $lastname = test_input($_POST["RegisterFormLastName"]);
        if (!preg_match("/^[A-Za-z'-ÀÁÂÃÄÅÇÈÉÊËÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäèéçêëìíîïòóôõöùúûü ]*$/",$lastname)) {
            $lastnameErr = $lastname." is een ongeldige naam";
            unset($_SESSION["lastname"]);
        }
        else {
          $_SESSION["lastname"] =$lastname;
        }
    }

    if ((isset($_POST["RegisterFormEmail"]))&&(empty($_POST["RegisterFormEmail"]))) {
        $email1Err = "Email is vereist";
    }
    else {
        $email1 = test_input($_POST["RegisterFormEmail"]);
        if (!filter_var($email1, FILTER_VALIDATE_EMAIL)) {
            $email1Err = $email1." is een ongeldig mail-formaat";
            unset($_SESSION["email1"]);
        }
    }

    if ((isset($_POST["RegisterFormEmailRepeat"]))&&(empty($_POST["RegisterFormEmailRepeat"]))) {
        $email2Err = "Email is vereist";
    } else {
        $email2 = test_input($_POST["RegisterFormEmailRepeat"]);
        if (!filter_var($email2, FILTER_VALIDATE_EMAIL)) {
            $email2Err = $email2." is een ongeldig mail-formaat";
            unset($_SESSION["email2"]);
        }
    }

    if ($email1 != $email2){
        $emailCompareErr = "emails komen niet overeen, probeer opnieuw";
    } else {
        $_SESSION["email1"] =$email1;
        $_SESSION["email2"] =$email2;
    }


    if ((isset($_POST["RegisterFormPassword1"]))&&(empty($_POST["RegisterFormPassword1"]))) {
        $psw1Err = "Paswoord is vereist";
        unset($_SESSION["password1"]);
    } else {
        $psw1 = test_input($_POST["RegisterFormPassword1"]);
    }

    if ((isset($_POST["RegisterFormPassword2"]))&&(empty($_POST["RegisterFormPassword2"]))) {
        $psw2Err = "Paswoord is vereist";
        unset($_SESSION["password2"]);
    } else {
        $psw2 = test_input($_POST["RegisterFormPassword2"]);
    }

    if ($psw1 != $psw2) {
      echo("paswoorden komen niet overeen, probeer opnieuw");
    }
    else {
        $_SESSION["password1"] = $psw1;
        $_SESSION["password2"] = $psw2;
    }
   

    if ((isset($_POST["RegisterFormAdress"]))&&(empty($_POST["RegisterFormAdress"]))) {
        $streetErr = "Adres is vereist";
        unset($_SESSION["street"]);
    } else {
        $street = test_input($_POST["RegisterFormAdress"]);
        if (!preg_match("/^([1-9][e][\s])*([a-zA-Z]+(([\.][\s])|([\s]))?)+[1-9][0-9]*(([-][1-9][0-9]*)|([\s]?[a-zA-Z]+))?$/i",$street)) {
          $streetErr = $street."is een ongeldige adres";
            unset($_SESSION["street"]);
        }
        else {
          $_SESSION["street"] = $street;
        }
    }

    if ((isset($_POST["RegisterFormPostalNumber"]))&&(empty($_POST["RegisterFormPostalNumber"]))) {
        $postalErr = "Postnummer is vereist";
        unset($_SESSION["postalNr"]);
    } else {
        $postalNr = test_input($_POST["RegisterFormPostalNumber"]);
        if (!preg_match("/^[1-9][0-9]{2,4}$/",$postalNr)) {
            $postalErr = $postalNr."is een ongeldige belgisch postnummer";
            unset($_SESSION["postalNr"]);
        }
        else {
          $_SESSION["postalNr"]=$postalNr;
        }

    }
    if ((isset($_POST["RegisterPhone"]))&&(empty($_POST["RegisterPhone"])) ){
        $phoneErr = "Telefoon is vereist";
        unset($_SESSION["phone"]);
    } else {
        $phone = test_input($_POST["RegisterPhone"]);
        if (!preg_match("/^0\d{1,3}[ ]\d{2}[ ]\d{2}[ ]\d{2}$/",$phone)) {
          $phoneErr = $phone."is een ongeldige belgisch telefoonnummer";
            unset($_SESSION["phone"]);
        }
        else {
          $_SESSION["phone"]=$phone;
        }
    }

    if ((isset($_POST["RegisterFormGender"]))&&(empty($_POST["RegisterFormGender"]))) {
        $genderErr = "Gender is vereist";
        unset($_SESSION["gender"]);
    } else {
        $gender = test_input($_POST["RegisterFormGender"]);
        $_SESSION["gender"]=$gender;
    }

    if ((isset($_POST["date-picker"]))&& (empty($_POST["date-picker"]))) {
        $dateErr = "Geboortedatum is vereist";
        unset($_SESSION["birthdate"]);
    } else {
        $birthdate = test_input($_POST["date-picker"]);
        $_SESSION["birthdate"]=$birthdate;
    }
  }

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['RegisterFormPassword1']) && (isset ($_POST['RegisterFormPassword2']))) { 
        $hashed_password = password_hash($psw1, PASSWORD_BCRYPT);
        echo($hashed_password);
        if (password_verify($psw1, $hashed_password)) {
             echo('<br>  Password is valid!');
         } else {
             echo ('Invalid password.');
         }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!--  Required meta tags always come first  -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login</title>
    <!--  Font Awesome  -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="css/mdb.min.css" rel="stylesheet">
  <style>
    html{
      z-index:-3;
    }

    body {
      height: 100vh;
      background-color: #D17133;
      /*background: -moz-linear-gradient(286deg, rgba(209,113,51,1) 0%, rgba(209,113,51,1) 82%, rgba(87,47,21,1) 84%, rgba(87,47,21,1) 100%); !* ff3.6+ *!
      background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, rgba(209,113,51,1)), color-stop(82%, rgba(209,113,51,1)), color-stop(84%, rgba(87,47,21,1)), color-stop(100%, rgba(87,47,21,1))); !* safari4+,chrome *!
      background: -webkit-linear-gradient(286deg, rgba(209,113,51,1) 0%, rgba(209,113,51,1) 82%, rgba(87,47,21,1) 84%, rgba(87,47,21,1) 100%); !* safari5.1+,chrome10+ *!
      background: -o-linear-gradient(286deg, rgba(209,113,51,1) 0%, rgba(209,113,51,1) 82%, rgba(87,47,21,1) 84%, rgba(87,47,21,1) 100%); !* opera 11.10+ *!
      background: -ms-linear-gradient(286deg, rgba(209,113,51,1) 0%, rgba(209,113,51,1) 82%, rgba(87,47,21,1) 84%, rgba(87,47,21,1) 100%); !* ie10+ *!
      background: linear-gradient(164deg, rgba(209,113,51,1) 0%, rgba(209,113,51,1) 82%, rgba(87,47,21,1) 84%, rgba(87,47,21,1) 100%); !* w3c *!*/
      position: relative;
      z-index: -2;
    }

    h4{
      color: #D17133;
    }

    label{
      color: #532406;
      margin-bottom: -0.15rem;
      font-size: 0.8rem;
    }

    .error{
      color: red;
      float: right;
    }
    .error2{
      margin-top: 0.25rem;
    }
    .btn{
      font-weight: bold;
      color: #532406;
      border: 1px solid #D17133;
      margin: 0.5rem 0 0 0;
    }
    .btn2{
      font-weight: bold;
      color: #D17133;
      background: white;
      border: 1px solid #D17133;
      margin: 0.5rem 0 0.5rem 0;
      box-shadow: 0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);
      padding: .84rem 1.54rem;
      font-size: .81rem;
    }

    input::-webkit-input-placeholder {
      color: rgb(255, 0, 0);;
    }
    input:-ms-input-placeholder {
      color: rgb(255, 0, 0);;
    }
    input::-moz-placeholder {
      color: rgb(255, 0, 0);;
      opacity: 1;
    }
    input::placeholder {
      color:red;
    }

    form{
      background-color: #F7F7F7;
      left: 50%;
      top: 45%;
      position: absolute;
      -webkit-transform: translate3d(-50%, -50%, 0);
      -moz-transform: translate3d(-50%, -50%, 0);
      transform: translate3d(-50%, -50%, 0);
      -moz-box-shadow:    5px 5px 17px 0 #532406;
      -webkit-box-shadow: 5px 5px 17px 0 #532406;
      box-shadow:         5px 5px 17px 0 #532406;
    }

    @media only screen and (max-width: 600px) {
      form {
        left: 0;
        top: 0;
        -o-transform: none !important;
        -moz-transform: none !important;
        -ms-transform: none !important;
        -webkit-transform: none !important;
        transform: none !important;
      }
    }

    .form-control{
      margin-bottom: 1.5rem;
      color: #532406;
      background-color: #f7f7f7;
      border-bottom: 1px solid #D17133;
      border-top: none;
      border-left: none;
      border-right: none;
      border-radius: 0;
      height: 1.6rem;
      padding: 0;
    }

    .form-control:disabled, .form-control[readonly]{
      background-color: #f7f7f7;
    }

    .select-wrapper input.select-dropdown {
      border-bottom: 1px solid #D17133;
      line-height: 1.5;
      height: 1.6rem;
      color: #532406;
    }

    .dropdown-content li span{
      color: #D17133;
      padding: 0.25rem;
    }
    .select-wrapper span.caret{
      color: #D17133;
      top: 0;
      font-size: 1rem;
    }

    .input-group-addon{
      border-bottom: 1px solid #D17133;
    }

    .input-group-addon a, a:hover{
      color:#D17133;
    }

    #RegisterFormPasswordHelpBlock{
      margin-top: -1em;
    }

    h4 {
      font-weight: bold;
    }

    small,.right-corner a {
      font-size: 0.75rem;
    }

    .picker__box .picker__header .picker__date-display .picker__weekday-display {
      background-color: #D17133;
    }
    .picker__box .picker__header .picker__date-display {
      background-color: #D17133;
    }
    .picker__box .picker__table .picker--focused, .picker__box .picker__table .picker__day--selected, .picker__box .picker__table .picker__day--selected:hover {
      background-color: #D17133;
    }
    .picker__box .picker__table .picker__day.picker__day--today {
      color: #D17133;
    }

    .text-muted {
      color: #1B67BF !important;
    }

    #triangle-bottomright {
      width: 0;
      height: 0;
      border-bottom: 25vh solid #f7f7f7;
      border-left: 50vw solid transparent;
      position: absolute;
      bottom: 0;
      z-index: -2;
    }

    .right-corner{
      position: absolute;
      bottom: 0;
      left: 0;
      z-index: -1;
    }
   @media screen and (max-width: 600px){
     form{
       overflow-y: scroll;
       width: 90%;
       margin-left: 5%;
       height: 500px;
       margin-top: 100px;
     }
     #triangle-bottomright {
       width: 100px;
       height: 0;
       border-bottom: 15vh solid #f7f7f7;
       border-left: 180vh solid transparent;
       border-right: O solid transparent;
       position: absolute;
       bottom: 0;
       z-index: -2;
     }

     .right-corner{
       position: absolute;
       bottom: 0;
       left: 0;
       z-index: -1;
     }
     }
   }
  </style>
</head>
<body>


<!-- Default form register -->
<main class="container">
  <!-- Default form register $_SERVER["PHP_SELF"] exploits can be avoided by using the htmlspecialchars() function.-->
  <form class"testForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
                class="text-center border border-light p-5 max-vw-75" autocomplete="off" novalidate>

    <div class="mb-4">
        <img src ="img/svg/lock.svg"  alt ="slot"/>
     </div>

     <div class ="col-12 mt-2">
       <h4 class=" text-center mb-4 ">REGISTRATIE</h4>
     </div>

    <div class ="row">
  <!-- First name -->
     <div class ="col-12 col-sm-6 text-left">
        <label for="RegisterFormFirstName">Voornaam:</label> <label class ="error"><?php echo $firstnameErr;?></label>
        <input type="text" name ="RegisterFormFirstName" value="<?php echo $_SESSION["firstname"];?>" class="form-control" placeholder="voornaam" autofocus>
     </div>

  <!-- Last name -->
     <div class ="col-12 col-sm-6 text-left">
        <label for="RegisterFormLastName">Naam:</label> <label class ="error"><?php echo $lastnameErr;?></label>
        <input type="text" name="RegisterFormLastName" value="<?php echo $_SESSION["lastname"];?>" class="form-control" placeholder="naam">
     </div>
  </div>

  <div class ="row">
      <div class ="col-12 col-sm-6 text-left">
      <!-- E-mail -->
          <label for="RegisterFormEmail">Email:</label> <label class ="error"><?php echo $email1Err;?></label>
          <input type="email" name="RegisterFormEmail" value ="<?php echo $_SESSION["email1"];?>"class="form-control mb-0" placeholder="voorbeeld@email.be" autocomplete="off">
        <label class ="col-12 text-left pl-0">
          <small id="emailHelp" class="form-text text-muted mb-1 mb-sm-0">We zullen je e-mail <u> nooit</u> met iemand delen.</small></label>
      </div>
      <div class ="col-12 col-sm-6 text-left">
       <!-- Repeat E-mail -->
          <label for="RegisterFormEmailRepeat">Herhaal email:</label> <label class ="error"><?php echo $email2Err;?></label>
          <input type="email" name="RegisterFormEmailRepeat" value="<?php echo $_SESSION["email2"];?>" class="form-control mb-0" placeholder="voorbeeld@email.be" autocomplete="off">
          <p><small class="error error2"><?php echo $emailCompareErr;?></small></p>
      </div>
  </div>

  <div class ="row">
      <div class ="col-12 col-sm-6 text-left">
          <!-- Password -->
          <div class="form-group">
              <label for= "RegisterFormPassword1">Paswoord</label> <label class ="error"><?php echo $psw1Err;?></label>
              <div class="input-group" id="show_hide_password">
                  <input class="form-control mb-0" name="RegisterFormPassword1" value="<?php echo $_SESSION["password1"];?>" type="password" placeholder ="paswoord"> <!--"^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$"-->
                  <div class="input-group-addon">
                      <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                  </div>
              </div>
          </div>
      </div>
      <div class ="col-12 col-sm-6 text-left">
          <!-- Repeat Password -->
          <div class="form-group">
              <label for = "RegisterFormPassword2">Herhaal paswoord</label> <label class ="error"><?php echo $psw2Err;?></label>
              <div class="input-group" id="show_hide_password">
                  <input class="form-control mb-0" name="RegisterFormPassword2" value="<?php echo $_SESSION["password2"];?>" type="password" placeholder ="paswoord">
                  <div class="input-group-addon">
                    <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                  </div>
                </div>
          </div>
      </div>
      <div class ="col-12 text-left">
          <small id="RegisterFormPasswordHelpBlock" class="form-text text-muted mb-1 mb-sm-0">
            Tenminste 8 karakters waarvan minimum 1 hoofdletter, 1 kleine letter en 1 cijfer.
          </small>
      </div>
  </div>

  <div class ="row">
      <div class ="col-12 text-left">
          <!-- Adress -->
          <label for="RegisterFormAdress">Adres:</label> <label class ="error"><?php echo $streetErr;?></label>
          <input type="text" name="RegisterFormAdress" class="form-control" value="<?php echo $_SESSION["street"];?>" placeholder="straat & nr"><!--required pattern="/^([1-9][e][\s])*([a-zA-Z]+(([\.][\s])|([\s]))?)+[1-9][0-9]*(([-][1-9][0-9]*)|([\s]?[a-zA-Z]+))?$/i"-->
      </div>
  </div>

  <div class ="row">
        <div class ="col-12 col-sm-6 text-left">
            <!-- Postalnumber -->
            <label for="RegisterFormPostalNumber">Postcode:</label> <label class ="error"><?php echo $postalErr;?></label>
            <input type="text" name="RegisterFormPostalNumber" class="form-control" value="<?php echo $_SESSION["postalNr"];?>" placeholder="postnummer" minlength="4" maxlength="4">
        </div>
        <div class ="col-12 col-sm-6 text-left">
             <!-- City -->
            <label for="RegisterFormCity">Gemeente:</label>
            <input type="text" name="RegisterFormCity" class="form-control" placeholder="gemeente">
        </div>
   </div>

   <div class ="row">
        <div class ="col-12 col-sm-6 text-left">
            <!-- Phone number -->
             <label for="RegisterPhoner"> GSM/Telefoon: </label> <label class ="error"><?php echo $phoneErr;?></label>
             <input type="tel" name="RegisterPhone" value="<?php echo $_SESSION["phone"];?>" class="form-control" placeholder="((0)0)09 99 99 99">
        </div>
        <div class ="col-12 col-sm-6 text-left">
            <label for="RegisterFormGender">Geslacht:</label>
            <select name="RegisterFormGender" class=" form-control mdb-select">
                <option value="" disabled selected>Kies je genderidentiteit</option>
                <option value="M">M</option>
                <option value="V">V</option>
                <option value="X">X</option>
            </select>
        </div>
   </div>

    <div class ="row">
        <div class ="col-12 col-sm-6 text-left mb-0">
  <!-- Birthdate -->
            <label for="date-picker">Geboortedatum</label> <label class ="error"><?php echo $dateErr;?></label>
            <input placeholder="selecteer datum" type="text" name="date-picker" data-value ="<?php echo $_SESSION["birthdate"];?>" class="form-control datepicker mb-0" required>
        </div>

        <div class ="col-12 col-sm-6 text-right mb-0">
            <!-- Sign up button -->
            <button class="btn" type="submit">Registreren</button>
        </div>
    </div>
  </form>
</main>
<footer>


   



  <div class="d-flex flex-row-reverse">
    <div class="triangle"></div>
      <div class= "d-flex" id = "triangle-bottomright">
      </div>
  </div>

    <!-- Default form register-->
  <div class="container-fluid">

      <div class="row">
    <!-- Terms of service -->
          <div class="right-corner col-12 text-right mb-2 mr-2">
              <div class ="col-6 text-right mb-0">

              </div>
              <!-- Sign up button -->
               <button class="btn2" type="submit">REEDS EEN ACCOUNT? LOGIN</button>
               <br>
               <a href="" target="_blank">Algemene Voorwaarden -</a>
               <a href="" target="_blank">Privacybeleid -</a>
               <a href="" target="_blank">Cookiebeleid</a>
          </div>
      </div>
  </div>
</footer>

</body>
</html>

<!-- Default form login -->

<script type="text/javascript" src="js/jquery-3.3.1.min.js">


</script>


<!-- Bootstrap tooltips -->
<script type="text/javascript" src="js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="js/bootstrap.min.js">

</script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="js/mdb.min.js"></script>
<script>// Data Picker Initialization

  $('.datepicker').pickadate({
    monthsFull: [ 'januari', 'februari', 'maart', 'april', 'mei', 'juni', 'juli', 'augustus', 'september', 'oktober', 'november', 'december' ],
    weekdaysShort: ['zo', 'ma', 'di', 'wo', 'do', 'vr', 'za'],
    weekdaysFull: [ 'zondag', 'maandag', 'dinsdag', 'woensdag', 'donderdag', 'vrijdag', 'zaterdag' ],
    monthsShort: [ 'jan', 'feb', 'maart', 'apr', 'mei', 'jun', 'jul', 'aug', 'sep', 'okt', 'nov', 'dec' ],
    selectYears: 90,
    max: -6574,
    firstDay: 1,
    today: 'vandaag',
    clear: 'wis',
    close: 'sluiten',
    format: 'dddd d mmmm yyyy',
    formatSubmit: 'yyyy/mm/dd'
  });

  $(document).ready(function() {
    $("#show_hide_password a").on('click', function(event) {
      event.preventDefault();
      if($('#show_hide_password input').attr("type") == "text"){
        $('#show_hide_password input').attr('type', 'password');
        $('#show_hide_password i').addClass( "fa-eye-slash" );
        $('#show_hide_password i').removeClass( "fa-eye" );
      }else if($('#show_hide_password input').attr("type") == "password"){
        $('#show_hide_password input').attr('type', 'text');
        $('#show_hide_password i').removeClass( "fa-eye-slash" );
        $('#show_hide_password i').addClass( "fa-eye" );
      }
    });
  });

// Material Select Initialization
$(document).ready(function() {
$('.mdb-select').materialSelect();
});

</script>

<script>
  new WOW().init();

</script>

