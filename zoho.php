<?php 
class zoho{

    public function getAuth()
    {
	//return "zxxxxx";
        $username = "user";
        $password = "password";
        $param = "SCOPE=ZohoCRM/crmapi&EMAIL_ID=".$username."&PASSWORD=".$password;
        $ch = curl_init("https://accounts.zoho.com/apiauthtoken/nb/create");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $result = curl_exec($ch);
        /*This part of the code below will separate the Authtoken from the result.
        Remove this part if you just need only the result*/
        $anArray = explode("\n",$result);
        $authToken = explode("=",$anArray['2']);
        $cmp = strcmp($authToken['0'],"AUTHTOKEN");
        echo $anArray['2'].""; if ($cmp == 0)
        {
        echo "Created Authtoken is : ".$authToken['1'];
        return $authToken['1'];
        }
        curl_close($ch);
    }   



public function postData($auth, $fornavn,$efternavn, $email,$addr,$by,$postnr,$land,$kommentar)
    {
        $xml = 
        '<?xml version="1.0" encoding="UTF-8"?>
        <Contacts>
        <row no="1">
        <FL val="First Name">'.$fornavn.'</FL>
        <FL val="Last Name">'.$efternavn.'</FL>
        <FL val="Email">'.$email.'</FL>
        </row>
        </Contacts>';

    $url ="https://crm.zoho.com/crm/private/xml/Contacts/insertRecords";
    $query="authtoken=".$auth."&scope=crmapi&newFormat=1&xmlData=".$xml;
    $ch = curl_init();
    /* set url to send post request */
    curl_setopt($ch, CURLOPT_URL, $url);
    /* allow redirects */
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    /* return a response into a variable */
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    /* times out after 30s */
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    /* set POST method */
    curl_setopt($ch, CURLOPT_POST, 1);
    /* add POST fields parameters */
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);// Set the request as a POST FIELD for curl.

    //Execute cUrl session
    $response = curl_exec($ch);
    curl_close($ch);
    echo $response;
    if (strpos($response, "added successfully")=== false) return 200;
    else return 500;
    

    }
}

?>
