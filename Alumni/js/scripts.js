var CONTROLLER_LINK = "controller.php";

 function setup(param, logged_in = false)
 { 
     switch (param)
     {
         case 'load':
             url = CONTROLLER_LINK+"?action=achievements"
             $.get(url,loadAchievements);
             if(logged_in)
             {
                 var username = $('#session').val();
                 makeNecessaryChanges(username);
             }
             break;
         case 'login':
            username = $('#login_username').val();
            pass = $('#login_password').val();
            $.post(CONTROLLER_LINK,
            {
                action : 'login',
                username : username,
                pass : pass
            },
            login);
            break;
        default:
            console.log("Nothing Done ");   
     }
 }


function changeHrefs()
{
    $('#gallerylink').attr("href","gallery.html");
    $('#postinglink').attr("href","posting.html");
    $('#eventslink').attr("href","events.html");
    $('#groupcharlink').attr("href","#");
    $('.navbar .dropdown-menu').children().removeAttr('data-toggle');
}

function makeNecessaryChanges(username)
{
    changeHrefs();
    $('#loginButton').css("display","none");
    $('#signUp').css("display","none");
    $('#loggedInAs').text(`Welcome ${username}`);
}

function login(data, status)
{
    if(status == 'success')
    {
        if(data)
        {
            $('#myloginmodal small').removeClass('text-danger');
            $('#myloginmodal small').addClass('text-success');
            $('#myloginmodal small').text('successfull');

            makeNecessaryChanges(data);
        }
        else
        {
            $('#myloginmodal small').text('Invalid username/password');
        }
    }
    else
        $('#myloginmodal small').text('failed to Connect');
        
}

function loadAchievements(data,status)
{
    data = JSON.parse(data);

    if(data.length == 0)
        return;
    
    // nested - function
    var createHolder = (type)=>{
        return $('<div></div>').addClass(type);
    }

    var carousel_inner = $('.carousel-inner');
    
    //removes all the children elements... i.e., all of the dummy cards or previously loaded content
    carousel_inner.empty();
    
    var carousel_item, container, row, cardgrp;
    
    for(let i=0; i< data.length;i++)
    {
        if(i%3 == 0)
        {
            carousel_item = createHolder("carousel-item");
            if(i==0)
                carousel_item.addClass("active");
            container = createHolder("container");
            row = createHolder("row");
            cardgrp = createHolder('card-group col');
            row.append(cardgrp);
            container.append(row);
            carousel_item.append(container);
            carousel_inner.append(carousel_item);
        }

        var card = createCard(data[i]);
        cardgrp.append(card);
    }
    $(".carousel.slide").removeClass('d-none'); //making it visible
}


function createCard(jsonObject)
{
    var alumniName = jsonObject.alumni_name;
    var description = jsonObject.desc;
    var photo_url = jsonObject.url;

    var card = $('<div></div>').addClass('card text-center m-2');
    
    var image = $('<img/>')
                        .addClass('card-img-top rounded-circle w-50 h-100 mx-auto mt-2')
                        .attr("src",photo_url)
        
    var cardBody = $('<div></div>').addClass('card-body')
    var cardTitle = $('<h5></h5>').addClass('card-title').text(alumniName);
    var cardText = $('<div></div>').addClass('card-text lead').text(description);

    cardBody.append(cardTitle, cardText);
    card.append(image, cardBody);

    return card;
   
}

