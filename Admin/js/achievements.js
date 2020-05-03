var CONTROLLER_LINK = "controller.php";

jq = $.noConflict();

function setup(param)
{

  switch(param)
  {
        case 'load':
            jq.get(CONTROLLER_LINK+"?action=names", loadDatalist);
            jq.get(CONTROLLER_LINK+"?action=getachievements",loadAchievements);
            break;
    
        case 'postachievement':
            let val = jq("#email").val().split("(")[1].slice(0,-1) //name (email)
            form = document.getElementById("achievementsform");
            formdata = new FormData(form);
            formdata.set("email",val);

            jq.ajax({
                type: "POST",
                url: CONTROLLER_LINK+"?action=postachievement",
                data: formdata,
                processData: false,
                contentType: false,
                success: achievementAck
            });
            break;
  }
}

function loadDatalist(data, status)
{
    data = JSON.parse(data);

    if(data.length == 0)
    {
        // disable add achievement btn
        return;
    }

    datalist = jq("#names");

    for(var name of data)
    {
        option = jq("<option>").attr("value",`${name.username} (${name.email})`);
        datalist.append(option);
    }

    jq("#achievementsform button").removeAttr("disabled");
}

function achievementAck(data, status)
{
    console.log(data);
    if(data)
    {
       jq("#divpost").addClass("text-success mt-3");
        jq('#ackpost').addClass("fas fa-thumbs-up").text("  Successfully posted");
        setup('load');
    }
    else
    {
        jq("#divpost").addClass("text-danger mt-3");
        jq('#ackpost').addClass("fas fa-thumbs-down").text("  Failed to post");
    }
}

var createDiv = (class_)=>
{
    return jq("<div></div>").addClass(class_);
}

function loadAchievements(data,status)
{
    data = JSON.parse(data);
    container = jq('#achievements');
    container.empty();

    var row;
    var n_cards = 3;
    for(var i = 0 ;i<data.length;i++)
    {
        if(i%3==0)
        {
            row = createDiv("row");
            container.append(row);
        }
        card = createCard(data[i], n_cards);
        row.append(card);
    }

}
function createCard(data, n_cards) 
{   
    var card = jq("<div></div>")
                .addClass(`card col-12 col-md-${parseInt(12/n_cards)} text-center m-1 m-sm-2`)
                .attr({"style":`max-width: ${100/n_cards-3}%;`})

    var img_name_row = createDiv("row no-gutters");

    var image = jq("<img/>")
      .addClass("card-img rounded-circle col-md-3")
      .attr("src", data.url);
    
    var cardTitle = jq("<h5></h5>").addClass("card-title offset-md-1 col-md-7 align-self-center").text(data.alumni_name);

    img_name_row.append(image, cardTitle);

    var cardBody =jq("<div></div>").addClass("card-body row align-items-center");
    cardText=jq("<p></p>").addClass("card-text d-none d-sm-block col-12").text(data.desc);
    
    cardBody.append(cardText);

    cardFooter = createDiv("card-footer")
    delbtn = jq("<button></button>")
            .addClass("btn btn-block btn-outline-danger")
            .text("Delete")
            .click(function(){
                jq.get(
                    CONTROLLER_LINK+`?action=deleteachievement&url=${data.url}`,
                    deleteAck
                )
            });
    cardFooter.append(delbtn);
    card.append(img_name_row, cardBody, cardFooter);
  
    return card;
}

function deleteAck(data, status)
{
    if(data)
        setup('load');
    else
        console.log('failed');
}