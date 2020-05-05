var CONTROLLER_LINK = "controller.php";
jq = $.noConflict();


function setup(param)
{
    switch(param)
    {
        case 'load':
            jq.get(CONTROLLER_LINK+"?action=getstats",loadStats);
            break;
    }
}
function loadStats(data,status)
{ 
    console.log(data);
    data=JSON.parse(data);
    jq("#achievements").text(data.n_ach);
    jq("#alumnis").text(data.n_alumni);
    jq("#events").text(data.n_event);
    jq("#postings").text(data.n_posting);
    util();
}
function util()
{
    jq('.counter').counterUp({
        delay: 5,
        time: 500
    });
}