//catch_scene
var jwt_sha256;

jwt_sha256 = (function(){

function dynamicallyLoadScript(url) {
    var script = document.createElement("script"); // Make a script DOM node
    script.src = url; // Set it's src to the provided URL

    document.head.appendChild(script); // Add it to the end of the head section of the page (could change 'head' to 'body' to add it to the end of the body section instead)
}
dynamicallyLoadScript("crypto_hmac-sha256.js");
dynamicallyLoadScript("crypto_enc-base64-min.js");
//dynamicallyLoadScript("//cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/hmac-sha256.js");
//dynamicallyLoadScript("//cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/components/enc-base64-min.js");



var header = {
  "alg": "HS256",
  "typ": "JWT"
};
/*
var data = {
  "id": 1337,
  "username": "john.doe"
};
*/
var secret = "My very confidential secret!!!";

function base64url(source) {
  // Encode in classical base64
  encodedSource = CryptoJS.enc.Base64.stringify(source);
  
  // Remove padding equal characters
  encodedSource = encodedSource.replace(/=+$/, '');
  
  // Replace characters according to base64url specifications
  encodedSource = encodedSource.replace(/\+/g, '-');
  encodedSource = encodedSource.replace(/\//g, '_');
  
  return encodedSource;
}

function _encode(data){
	console.log('_encode');
   var stringifiedHeader = CryptoJS.enc.Utf8.parse(JSON.stringify(header));
   var encodedHeader = base64url(stringifiedHeader);
//document.getElementById("header").innerText = encodedHeader;
//header
   var stringifiedData = CryptoJS.enc.Utf8.parse(JSON.stringify(data));
   var encodedData = base64url(stringifiedData);
//document.getElementById("payload").innerText = encodedData;
//payload
   var signature = encodedHeader + "." + encodedData;
   signature = CryptoJS.HmacSHA256(signature, secret);
   signature = base64url(signature);
//document.getElementById("signature").innerText = signature;
//signature
   var result_text = encodedHeader+'.'+encodedData+'.'+signature;
   return result_text;
}
function _decode(token){
   var base64Url = token.split('.')[1];
   var base64 = base64Url.replace('-', '+').replace('_', '/');
   return JSON.parse(window.atob(base64));
}
   return {
      encode : function (data){
         return  _encode(data);
	  },
	  decode : function (token){
		 return _decode(token);
	  }
   };
   result_text;
}());