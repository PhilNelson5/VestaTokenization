<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
  <head>
  <title>Vesta API Test Tool</title>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles/mystyle.css">
    <script type="text/javascript" src="scripts/vestatoken-1.0.3.js"></script>
    <script type="text/javascript">
        vestatoken.init({
//        ServiceURL: "https://paysafesandbox.ecustomersupport.com/GatewayProxyJSON/Service",
        ServiceURL: "https://paysafe.ecustomerpayments.com/GatewayProxyJSON/Service",
       AccountName: "listia"
//        AccountName: "c91yKKKHf+rCSzgwdeuD9g=="
        });
    </script>
</head>
    <body>
                <p>Select the API from the dropdown you wish to test.</p><br>
       
 <form id="form1" method="post" action="actions.php">       
        <select id="select" name="api_method" onChange="handleSelection(value)">
            <option value="empty">Choose API Call</option>
            <option value="ChargeSale">Charge Sale</option>
            <option value="ChargeAuthorize">Charge Authorize</option>
            <option value="GetSessionTags">Get Session Tags</option>
        </select>
        
        <p><br>Enter the required parameters to make your api call.</p>
        <p><br>This example page is meant to use the vesta tokenization service to get the client out of PCI scope.</p>
        <p><br>GetSessionTags and Token call will happen automatically in this demo.</p>
<fieldset>
<div id="container1" class="hidden">
   <div id="accountName">
    <label class="requiredred" for="AccountName">Account Name:</label> <input type="text" id="AccountName" name="AccountName" />
  </div>
   <div id="cardHolderAddressLine1">
    <label class="requiredred" for="CardHolderAddressLine1">Address Line 1:</label> <input type="text" id="CardHolderAddressLine1" name="CardHolderAddressLine1" />
  </div>
   <div id="cardHolderAddressLine2">
    <label class="optional" for="CardHolderAddressLine2">Address Line 2:</label> <input type="text" id="CardHolderAddressLine2" name="CardHolderAddressLine2" />
  </div>
   <div id="cardHolderCity">
    <label class="requiredred" for="CardHolderCity">City:</label> <input type="text" id="CardHolderCity" name="CardHolderCity" />
    </div>
   <div id="cardHolderCountryCode">
    <label class="requiredred" for="CardHolderCountryCode">Country Code:</label> <input type="text" id="CardHolderCountryCode" name="CardHolderCountryCode" />
  </div>
  <div id="cardHolderFirstName">
    <label class="requiredred" for="CardHolderFirstName">First Name:</label> <input type="text" id="CardHolderFirstName" name="CardHolderFirstName" />
  </div>
   <div id="cardHolderLastName">
    <label class="requiredred" for="CardHolderLastName">Last Name:</label> <input type="text" id="CardHolderLastName" name="CardHolderLastName" />
  </div> 
   <div id="cardHolderPostalCode">
    <label class="requiredred" for="CardHolderPostalCode">Postal Code:</label> <input type="text" id="CardHolderPostalCode" name="CardHolderPostalCode" />
  </div> 
   <div id="cardHolderRegion">
    <label class="requiredred" for="CardHolderRegion">Region:</label> <input type="text" id="CardHolderRegion" name="CardHolderRegion" />
  </div>
   <div id="creditCardNumber">
    <label class="requiredred" for="CreditCardNumber">Credit Card Number:</label> <input type="text" id="CreditCardNumber" name="CreditCardNumber" />
  </div>
   <div id="chargeAmount">
    <label class="requiredred" for="ChargeAmount">Charge Amount:</label> <input type="text" id="ChargeAmount" name="ChargeAmount" />
  </div>
   <div id="chargeCVN">
    <label class="optional" for="ChargeCVN">Charge CVN:</label> <input type="number" id="ChargeCVN" name="ChargeCVN" />
  </div>
   <div id="chargeExpirationMMYY">
    <label class="optional" for="ChargeExpirationMMYY">Card Expiration MMYY</label> <input type="text" id="ChargeExpirationMMYY" name="ChargeExpirationMMYY" />
  </div>
   <div id="chargeSource">
    <label class="requiredred" for="ChargeSource">Charge Source (PPD, TEL, WEB)</label> <input type="text" id="ChargeSource" name="ChargeSource" />
  </div>
   <div id="isTempToken">
    <label class="requiredred" for="IsTempToken">Is Temp Token</label> <input type="radio" id="IsTempToken" name="IsTempToken" value="true" />
  </div>
   <div id="password">
    <label class="requiredred" for="Password">Password:</label> <input type="text" id="Password" name="Password" />
  </div>
   <div id="paymentDescriptor">
    <label class="optional" for="PaymentDescriptor">Payment Descriptor:</label> <input type="text" id="PaymentDescriptor" name="PaymentDescriptor" />
  </div>
   <div id="riskInformation">
    <label class="optional" for="RiskInformation">Risk Information Blob</label> <input type="text" id="RiskInformation" name="RiskInformation" />
  </div>
   <div id="storeCard">
    <label class="optional" for="StoreCard">Store Card:</label> <input type="radio" id="StoreCard" name="StoreCard" value="true"/>
  </div>
   <div id="transactionID">
    <label class="requiredred" for="TransactionID">Transaction ID:</label> <input type="text" id="TransactionID" name="TransactionID" />
  </div>
   <div id="webSessionID" class="hidden">
    <label class="optional" for="WebSessionID">Web Session ID:</label> <input type="text" id="WebSessionID" name="WebSessionID" />
  </div>
   <div id="chargeAccountNumberToken " class="hidden">
    <label class="optional" for="ChargeAccountNumberToken">Token:</label> <input type="text" id="ChargeAccountNumberToken" name="ChargeAccountNumberToken" />
  </div>
</div>


  <input id="Submit" type="submit" value="submit">
  <script type="text/javascript">
document.getElementById('form1').onsubmit = function() {
    console.log('HERE WE ARE');
    vestatoken.getcreditcardtoken({
        ChargeAccountNumber: document.getElementById('CreditCardNumber').value,
        onSuccess: function(data) {
        console.log('SWAP CREDIT CARD NUMBER');
          // make use of `data.ChargeAccountNumberToken` (String), `data.PaymentDeviceLast4` (String) and `data.PaymentDeviceTypeCD` (String)
  
          form1.elements["ChargeAccountNumberToken"].value = data.ChargeAccountNumberToken;
          console.log('success' + JSON.stringify(data));
           return data;
        },
        onFail: function(failure) {
          // make use of `failure` (String)
          console.log('onfail' + JSON.stringify(data));
          alert('onfail');
          return false;
        },
        onInvalidInput: function(failure) {
          // make use of `failure` (String)
          console.log('invalid input' + JSON.stringify(data));
          alert('invalidinput');
          return false;
        }
    });

    alert("This is here because I can't figure out async or callbackto get getCreditCardToken to complete before form submit happens");
    return;
}
</script>
</fieldset>
</form>
   
<a class="btn btn-primary btn-med navbar-btn right" target="_blank" style="color: #fff" href='https://apigee.com/janrain/embed/console/jump-api?v=2&req={"resource"%3A"method_1216"%2C"params"%3A{}%2C"template"%3A{}%2C"headers"%3A{}%2C"verb"%3A"post"}'>
    <i class="janrain-icon-dashboard"></i>&nbsp;  Demo console
</a>

<script type="text/javascript">
function handleSelection(choice) {
if(choice==='ChargeSale')
	{
            console.log('Inside ChargeSale');
            $(".hidden > *").css('display','none');
            $("#transactionID").show();
            $("#paymentDescriptor").show();
            $("#riskInformation").show();
            $("#storeCard").show();
            $("#password").show();
            $("#chargeExpirationMMYY").show();
            $("#chargeSource").show();
            $("#isTempToken").show();
            $("#chargeAccountNumberToken").show();
            $("#chargeAmount").show();
            $("#chargeCVN").show();
            $("#cardHolderAddressLine1").show();
            $("#cardHolderAddressLine2").show();
            $("#cardHolderCity").show();
            $("#cardHolderCountryCode").show();
            $("#cardHolderLastName").show();
            $("#cardHolderFirstName").show();
            $("#cardHolderPostalCode").show();
            $("#cardHolderRegion").show();
            $("#accountName").show();
            $("#ChargeSale").show();
            $("#creditCardNumber").show();
            document.getElementById('container1').style.display="block";
	}
	else if (choice==='ChargeAuthorize')
	{
            $(".hidden > *").css('display','none');
            $("#transactionID").show();
            $("#creditCardNumber").show();
            $("#paymentDescriptor").show();
            $("#riskInformation").show();
            $("#storeCard").show();
            $("#password").show();
            $("#chargeExpirationMMYY").show();
            $("#chargeSource").show();
            $("#isTempToken").show();
            $("#chargeAccountNumberToken").show();
            $("#chargeAmount").show();
            $("#chargeCVN").show();
            $("#cardHolderAddressLine1").show();
            $("#cardHolderAddressLine2").show();
            $("#cardHolderCity").show();
            $("#cardHolderCountryCode").show();
            $("#cardHolderLastName").show();
            $("#cardHolderFirstName").show();
            $("#cardHolderPostalCode").show();
            $("#cardHolderRegion").show();
            $("#accountname").show();
            $("#ChargeSale").show();
            document.getElementById('container1').style.display="block";

	}
        else if (choice==='GetSessionTags') {
            console.log('Inside Get Session Tags');
            $(".hidden > *").css('display','none');
            $("#accountname").show();
            $("#password").show();
            document.getElementById('container1').style.display="block";
        }
}
</script>
        <?php
        // put your code here
        ?>
    </body>
</html>
