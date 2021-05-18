var CONTROLLER_LINK = "controller.php";

function setup(param, logged_in = false) {
  switch (param) {
    case "load":
      url = CONTROLLER_LINK + "?action=achievements";
      $.get(url, loadAchievements);
      if (logged_in) {
        var username = $("#session").val();
        makeNecessaryChanges(username);
      }
      break;
    case "login":
      username = $("#login_username").val();
      pass = $("#login_password").val();
      valid=validateLogin(username,pass);
      if(valid)
      {
        $.post(
          CONTROLLER_LINK,
          {
            action: "login",
            username: username,
            password: pass,
          },
          login
        );
      }
      
     
      break;
    case 'signup':
      valid=validateSignup();
        if(valid)
        {
           
          var x = document.getElementById("submitform");
          formdata=new FormData(x);
          // formdata=formdata.serialize();
          $.ajax(
            {
              
              type:"POST",
              url:CONTROLLER_LINK+"?action=signup",
              data:formdata,
              processData: false,
              contentType: false,
              success:signupAck,
              error: function(errResponse) {
                console.log(errResponse);
            }      
            }
          );
        }
      
      break;

    default:
      console.log("Nothing Done ");
  }
}

function changeHrefs() {
  $("#gallerylink").attr("href", "gallery.php");
  $("#postinglink").attr("href", "posting.php");
  $("#eventslink").attr("href", "events.php");
  $("#groupchatlink").attr("href", "chat.php");
  $(".navbar .dropdown-menu").children().removeAttr("data-toggle");
}

function makeNecessaryChanges(username) {
  changeHrefs();
  $("#loginButton").css("display", "none");
  $("#signUp").css("display", "none");
  $("#loggedInAs").text(`Welcome ${username}`);

  $("#signoutButton").removeClass("d-none");
}

function login(data, status) 
{
  if (data != "0") 
  {
    var idx = data.lastIndexOf("@");
    var username = data.slice(0,idx);
    var usertype = data.slice(idx+1);
    
    if (usertype === 'alumni') 
    {
      $("#myloginmodal small").removeClass("text-danger");
      $("#myloginmodal small").addClass("text-success");
      $("#myloginmodal small").text("successfull");
      $("#myloginmodal").modal('toggle');
      
      makeNecessaryChanges(username);
    } 
    else if(usertype === 'admin')
    {
      document.getElementById("adminpagebtn").click();
    }
  
  }
  else
  {       
    $("#myloginmodal small").text("Invalid username/password");
  }
  // else
  // {
  //    $("#myloginmodal small").text("failed to Connect");   
  // }
}

function loadAchievements(data, status) {
  data = JSON.parse(data);

  if (data.length == 0) return;

  // nested - function
  var createHolder = (type) => {
    return $("<div></div>").addClass(type);
  };

  var carousel_inner = $(".carousel-inner");

  //removes all the children elements... i.e., all of the dummy cards or previously loaded content
  carousel_inner.empty();

  var carousel_item, container, row, cardgrp;

  for (let i = 0; i < data.length; i++) {
    if (i % 3 == 0) {
      carousel_item = createHolder("carousel-item");
      if (i == 0) carousel_item.addClass("active");
      container = createHolder("container");
      row = createHolder("row");
      cardgrp = createHolder("card-group col");
      row.append(cardgrp);
      container.append(row);
      carousel_item.append(container);
      carousel_inner.append(carousel_item);
    }

    var card = createCard(data[i]);
    cardgrp.append(card);
  }
  $(".carousel.slide").removeClass("d-none"); //making it visible
 
  $(".card").hover(
    function () {
        
      $(this).css("box-shadow", " 3px 3px 5px 6px rgb(107, 105, 105)");
      $(this).css("transform","scale(1.1, 1.1)");
    },
    function () {
      $(this).css("box-shadow", "none");
      $(this).css("transform","none");
    }
  );
}

function createCard(jsonObject) {
  var alumniName = jsonObject.alumni_name;
  var description = jsonObject.desc;
  var photo_url = jsonObject.url;

  
  var card = $("<div></div>").addClass("card text-center m-3");

  var image = $("<img/>")
    .addClass("card-img-top rounded-circle w-50 h-70 mx-auto mt-3")
    .attr("src", photo_url);

  var cardBody = $("<div></div>").addClass("card-body");
  var cardTitle = $("<h5></h5>").addClass("card-title").text(alumniName);
  var cardText = $("<div></div>").addClass("card-text lead").text(description);

  cardBody.append(cardTitle, cardText);
  card.append(image, cardBody);

  return card;
}
function signupAck(data, status)
{
   if(data)
   {
     $("#signUp").attr("class","d-none");     
     document.querySelector('#mysignupmodal .close').click();
    //  $('#mysignupmodal .close').click();
    document.querySelector('#loginButton').click();
     

   }     
   else{
     console.log('Invalid credentials');
   }
}

function validateLogin(username,password)
{
  if(username.length==0 || password.length==0)
  {

    $("#myloginmodal small").text("username and password required").addClass("text-danger");
    $("#login_username").attr("class","form-control is-invalid")
    $("#login_password").attr("class","form-control is-invalid")
    // $("#login_password").addClass("is-invalid");  
    return false;
  }

  return true;
  
}

function validateSignup()
{
  password = $("#password").val();
  re=$("#repassword").val();
  arr=document.getElementById("submitform").elements;
  for(var i =0;i<arr.length;i++)
  {
     console.log(arr.item(i).name);
    if(arr.item(i).name.length!=0)
    temp="#"+arr.item(i).name;

    if(arr.item(i).value.length==0)
    {
        $(temp).removeClass("is-valid");  
        $(temp).attr("class","form-control  mb-3 is-invalid");
        $(temp+"-"+"invalid").removeClass("d-none");
        $(temp+"-"+"invalid").attr("class","invalid-feedback")
           
          $("#text-prompt-signup").text("Please Enter all the details");
          return false;
    }
    else if(arr.item(i).name=="password" ||arr.item(i).name=="repassword" )
    {
       console.log("in password");
      pass=$("#password").val();
      re=$("#repassword").val();
            if(pass!=re)
            {
              $("#password").removeClass("is-valid");  
              $("#password").attr("class","form-control is-invalid mb-3");
              $("#password"+"-"+"invalid").removeClass("d-none");
              $("#password"+"-"+"invalid").attr("class"," text-danger invalid-feedback").text("passwords must match ").append("<i class='far fa-times-circle'>");
              $("#repassword").removeClass("is-valid");  
              $("#repassword").attr("class","form-control is-invalid mb-3");
              $("#repassword"+"-"+"invalid").removeClass("d-none");
              $("#repassword"+"-"+"invalid").attr("class","text-danger invalid-feedback")
              return false;
            }
            else
            {
              $("#password").removeClass("is-invalid");  
              $("#password").attr("class","form-control is-valid mb-3");
              $("#password"+"-"+"valid").removeClass("d-none");
              $("#password"+"-"+"valid").attr("class","text-success valid-feedback");
              $("#repassword").removeClass("is-invalid");  
              $("#repassword").attr("class","form-control is-valid mb-3");
              $("#repassword"+"-"+"valid").removeClass("d-none");
              $("#repassword"+"-"+"valid").attr("class","text-success valid-feedback")
              $("#text-prompt-signup").text("");
            }
    }
    else if(arr.item(i).name=="email")
    {
     var re= /\S+@\S+\.\S+/;
     if(!re.test($("#email").val()))
     {
      $("#email").removeClass("is-valid");  
      $("#email").attr("class","form-control is-invalid mb-3");
      $("#email"+"-"+"invalid").removeClass("d-none");
      $("#email"+"-"+"invalid").attr("class","text-danger invalid-feedback").text("email must be appropiate ").append("<i class='far fa-times-circle'>");
      return false;
     }
     else
     {
       $("#email").removeClass("is-invalid");
       $("#email").attr("class","form-control is-valid mb-3");
       $("#email"+"-"+"valid").removeClass("d-none");
       $("#email"+"-"+"valid").attr("class","text-success valid-feedback");
       $("#text-prompt-signup").text("");
     }

    }
    else
    {
      $(temp).removeClass("is-invalid");
      $(temp).attr("class","form-control is-valid mb-3");
      $(temp+"-"+"valid").removeClass("d-none");
      $(temp+"-"+"valid").attr("class","text-success valid-feedback")
      $("#text-prompt-signup").text("");
    }
   
  }
  
 

  return true;
}

$('#myloginmodal #login_password').keypress(function (e) {
  var key = e.which;
  if(key == 13)  // the enter key code
   {
     $('#submitButton').click();
   }
 });   