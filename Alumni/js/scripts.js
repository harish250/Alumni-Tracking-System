
// /*
var CONTROLLER_LINK = "controller.php";

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
    var jsonObject = JSON.parse(data);
    var carouselInner = document.getElementsByClassName("carousel-inner")[0];

    var carouselItem = createCarouselItem();
    var container = createContainer();
    
    var row = createRow();
    container.appendChild(row);
    carouselItem.appendChild(container);
    var a = new Array();
    var card ;
    for(var i = 0 ; i<jsonObject.length;i++)
    {
        if((i+1)%3==0)
        {
            card=createCard(jsonObject[i]);
            row.appendChild(card);
            carouselItem.appendChild(row);
            carouselInner.appendChild(carouselItem);
            carouselItem = createCarouselItem();
            container = createContainer();
            row = createRow();
            container.appendChild(row);
            carouselItem.appendChild(container);
        }
        else
        {
            card = createCard(jsonObject[i]);
            row.appendChild(card);
        }
    
    }
}
function createCarouselItem()
{
    //carousel-inner
    var createItem = document.createElement('div');
    createItem.className="carousel-item"; //carouse-item container
    
    return createItem;
}
function createContainer()
{
    var container = document.createElement('div');
    container.className = 'container';
    
return container;
}
function createRow()
{
    var row = document.createElement('div');
    row.className = 'row';

    return row;

}
 
function createCard(jsonObject)
{
    var alumniName = jsonObject.alumni_name;
    var description = jsonObject.desc;
    var photo_url = jsonObject.url;

    var col = document.createElement('div');
    col.className="col-md-4";

    var card = document.createElement("div");
    card.className="card text-center";
   
    var image = document.createElement("img");
    image.className = "card-img-top rounded-circle w-50 h-100 mx-auto mt-2";
    console.log(photo_url)
    image.setAttribute("src",photo_url);
    card.appendChild(image);

    var cardBody = document.createElement('div');
    cardBody.className='card-body';
    
    var cardTitle = document.createElement('h5');
    cardTitle.className="card-title ";
    cardTitle.textContent=alumniName;

    var cardText = document.createElement('div');
    cardText.className="card-text lead";
    cardText.textContent=description;

    cardBody.appendChild(cardTitle);
    cardBody.appendChild(cardText);
    card.appendChild(cardBody);
    col.appendChild(card);
    
    return col;
}


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
