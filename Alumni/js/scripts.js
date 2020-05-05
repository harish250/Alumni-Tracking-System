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
      $.post(
        CONTROLLER_LINK,
        {
          action: "login",
          username: username,
          password: pass,
        },
        login
      );
      break;
    default:
      console.log("Nothing Done ");
  }
}

function changeHrefs() {
  $("#gallerylink").attr("href", "gallery.php");
  $("#postinglink").attr("href", "posting.php");
  $("#eventslink").attr("href", "events.php");
  $("#groupcharlink").attr("href", "#");
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
  if (status == "success") 
  {
    var idx = data.lastIndexOf("@");
    var username = data.slice(0,idx);
    var usertype = data.slice(idx+1);
    
    if (usertype == 'alumni') 
    {
      $("#myloginmodal small").removeClass("text-danger");
      $("#myloginmodal small").addClass("text-success");
      $("#myloginmodal small").text("successfull");
      
      makeNecessaryChanges(username);
    } 
    else if(usertype == 'admin')
    {
      document.getElementById("adminpagebtn").click();
    }
    else
    {
      $("#myloginmodal small").text("Invalid username/password");
    }
  }
  else
  {
     $("#myloginmodal small").text("failed to Connect");   
  }
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
