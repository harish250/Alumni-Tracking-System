var CONTROLLER_LINK = "controller.php";
jq = $.noConflict();
function setup(param)
{
    switch(param)
    {
        case 'load':
            val = jq('#searchinput').val();
            val = val.replace(" ", "_");
            jq.get(CONTROLLER_LINK+`?action=getpostings&val=${val}`,makeTable);
            break;
        case 'post':
            company = $('#post_company').val();
            type = $('#job-posting-form option:selected').val();
            sal = $('#post_salary').val();
            desc = $('#post_desc').val();

            jq.post(CONTROLLER_LINK,
                {
                    action:"post",
                    company:company,
                    type:type,
                    salary:sal,
                    description:desc,
                },
            postAck)
    }
}

function pressSearchBtn(event) 
{
    if (event.keyCode === 13) {
      event.preventDefault();
      document.getElementById("searchbtn").click();
    }
}

function makeTable(data, status)
{
    var makeThead = ()=>{
        var maketh = (val)=>{
            return jq("<th></th>").text(val);
        }
        thead = jq("<thead></thead>");
        tr = jq("<tr></tr>");

        tr.append(maketh("Company"), maketh("Job Type"), maketh("Salary"));
        return thead.append(tr);
    }
    
    var makeRow = (posting)=>{
        var maketd=(val)=>
        {
            return jq("<td></td>").text(val);
        }
        tr = jq("<tr></tr>");
        tr.attr({
            'data-toggle':'modal',
            'data-target':'#jobDescriptionModal'
                });
        
        tr.click(function()
        {
            url=CONTROLLER_LINK+`?action=showdescription&job_id=${posting.job_id}`;
            jq.get(url,makeModal);
        });
        tr.append(maketd(posting.company), 
        maketd(posting.type),
        maketd(posting.salary));
        
        return tr;
    }
    
    data = JSON.parse(data);

    if(data.length == 0)
    {
        jq('#postingTable').hide(500);
        jq('#ack').show(500);
        return;
    }

    var table = jq("#postingTable");
    table.empty(); //removes all children
    
    table.append(makeThead());
    for(posting of data)
    {
        table.append(makeRow(posting));
    }
    
    jq('#ack').hide(500);
    jq('#postingTable').show(500);
}
                                
function makeModal(data,status)
{
    var getFormatedDate = (date)=>{
        curr_date = new Date();
        days_ago = (curr_date.getMonth() - date.getMonth())*30 + curr_date.getDate() - date.getDate();
        
        var divide = (days, val, append)=>{
            temp = Math.floor(days/val);
            return (temp)?temp+""+append+" ":"";
        }

        custom = "";
        custom += divide(days_ago,30,"m");
        days_ago %= 30;
        custom += divide(days_ago,7,"w");
        days_ago %= 7;
        custom += divide(days_ago,1,"d");
        
        return (custom)?`${custom} Ago`:"Today";
    }

    data = JSON.parse(data)[0];
    jq("#by").text(`${data.username}`)
    jq('#jobDescriptionModal .modal-title').text(`${data.company}`);
    jq('#type').text(` ${data.type}`);
    jq('#salary').text(` ${data.salary}`);
    jq('#description').text(data.description);
    
    del_option = $('<button></button>').attr("class","btn btn-danger")
    .text("Delete Post")
    .click(function(){
        url = CONTROLLER_LINK+`?action=delpost&job_id=${data.job_id}`;
        jq.get(url, delPostAck);
    });
    modal_footer = $('#jobDescriptionModal .modal-footer');
    modal_footer.find(".btn:first-child").remove();
    
    id = $('#session_id').val(); //this has the id value of the session stored
    modal_footer.prepend(del_option);   
    var disabled = id.toUpperCase() != data.id.toUpperCase(); // disabled is true if the session id and id of job posting uploader doesnt match
    $("#jobDescriptionModal .modal-footer .btn:first-child").attr('disabled', disabled);

    // process the date to give it as Months-Weeks-Days
    var date_posted = new Date(data.date_posted);
    fmt_date = getFormatedDate(date_posted);

    jq('#jobDescriptionModal .modal-footer span').text(fmt_date);
}

function postAck(data,status)
{
    if(data)
    {
        console.log("successfully posted");
        $('#post_ack').attr('class','text-success').text('Successfully Posted');
        setup('load'); //if the job was posted successfully , load the table again to view the Alumni his post
    }
    else
    {
        $('#post_ack').attr('class','text-danger').text('Failed to post');

        console.log("failed");

    }
}
function delPostAck(data, status)
{
    if(data)
    {
        setup('load');

    }
    else
    {
        console.log('failed to del post');
    }
}