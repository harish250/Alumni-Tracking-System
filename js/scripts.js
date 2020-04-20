
// /*
// var CONTROLLER_LINK = "url"

// function setup(param, loggedin){
//     switch(param):
//     case ...
//     case 'load':
//         fill the coursel --> this involves ajax call 
//         $.get('url?action=achivements',callback)
//         change the hrefs -->change_hrefs(loggedin)
//     case login:
//         $('#myloginmodal') -->get username and pass
//         $.post(url,
//             action: 'login',
//             username:
//             pass
//             callback_fun
//             )
// }
// */
var url = "./controller.php";
 function setup(param,loggedin=true)
 { 
     switch (param)
     {
         case 'load':
             loadContent(loggedin);
             break;
         case 'login':
            login();
            break;
        default:
            console.log("Nothing Done ");   
     }
 }




function loadContent(loggedIn)
{
   if(loggedIn)
   {
       var logInButton = document.getElementById("loginButton");
       logInButton.style.display="none";
       var signUp=document.getElementById("signUp");
       signUp.style.display="none";


     
     
   }
   
       loadAchievements();
       changeHrefs(loggedIn);
   

} 
function changeHrefs(loggedin)
{
  var galleryLink = document.getElementById('gallerylink');
  var postingLink = document.getElementById('postinglink');
  var eventsLink = document.getElementById("eventslink");
  var groupchatLink = document.getElementById("groupchatlink");

   if(loggedin)
   {
       galleryLink.href="gallery.html";
       postingLink.href="posting.html";
       eventsLink.href="events.html";
       groupchatLink.href ="#";
    //    remove attribute data-toggle
    galleryLink.removeAttribute("data-toggle","modal");
    postingLink.removeAttribute("data-toggle","modal");
    eventsLink.removeAttribute("data-toggle","modal");
    groupchatLink.removeAttribute("data-toggle","modal");
   }


}

function login()
{
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

        var xmlhttp = new XMLHttpRequest();
       var  tempurl = url;

        xmlhttp.onreadystatechange= function()
        {
            if(this.readyState==4 && this.status==200)
            {
               
              if(this.responseText.localeCompare("nouser")==0)
              {
                  promptUserNotValid();
                  console.log(this.responseText);
              }     
              else
              {
                var response =  JSON.parse(this.responseText);
                console.log(response); 
                  $('#myloginmodal').modal('hide');
                  loadContent(true);
                  setHelperText(response[1]);
              }   
            }
        }
        xmlhttp.open("POST",tempurl,true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
         xmlhttp.send("username="+username+"&password="+password+"&action="+"login");
}
 
function setHelperText(username)
{
    var navtext=document.getElementById("loggedInAs");
  
     navtext.innerHTML="Welcome "+username;

}
function loadAchievements()
{
    var xmlhttp = new XMLHttpRequest();
   var  tempurl = url+"?action=achievements"; 
    xmlhttp.onreadystatechange = function()
    {
        if(this.readyState==4 && this.status==200)
        {
           var jsonObject = JSON.parse(this.responseText); 
           for(achievement of jsonObject)
           {
               console.log(achievement);
           }
        }
    }
    xmlhttp.open("GET",tempurl,true);
    xmlhttp.send();
    
}
 function  promptUserNotValid()
 {
     
        var smallText = document.getElementById("text-prompt");
        
         smallText.innerHTML="Please Enter Valid username or password?";

 }
// function createCard(jsonObject)
// {

// }
/*
function ach_callback(xhttp)
{
    you will get the refs to the cards
    and fill in the resp data
}

function change_hrefs(loggedin= false)
{
    var links = $('point to the links')
    if(loggedin)
    {
        point hrefs to their resp files
        remove data-toggle
    }
    else
    {
        change hrefs so that they point to loginmodal
        and add data-toggle
    }
}

function login(xhttp)
{
    if(xhttp)
    {
        
    }
}
*/
