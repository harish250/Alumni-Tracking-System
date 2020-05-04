var CONTROLLER_LINK = "controller.php";

function setup(param)
{
    switch(param)
    {
        case 'customview':
            val = $('input[name="posting"]:checked').val();
            url = CONTROLLER_LINK+`?action=customview&id=${val}`;
            $.get(url, makeTable);
            break;
        case 'post':
            company = $('#post_company').val();
            type = $('#job-posting-form option:selected').val();
            sal = $('#post_salary').val();
            desc = $('#post_desc').val();

            $.post(CONTROLLER_LINK,
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

function makeTable(data, status)
{

    data = JSON.parse(data);

    if(data.length == 0)
    {
        $('#postingTable').hide(500);
        $('#ack').show(500);
        return;
    }
    var makeThead = ()=>{
        var maketh = (val)=>{
            return $("<th></th>").text(val)
        }
        thead = $("<thead></thead>");
        tr = $("<tr></tr>");

        tr.append(maketh("Company"), maketh("Job Type"), maketh("Salary"));
        return thead.append(tr);
    }
    
    var makeRow = (posting)=>{
        var maketd=(val)=>
        {
            return $("<td></td>").text(val);
        }
        tr = $("<tr></tr>");
        tr.attr({
            'data-toggle':'modal',
            'data-target':'#jobDescriptionModal'
                });
        
        tr.click(function()
        {
            url=CONTROLLER_LINK+`?action=showdescription&jobid=${posting.job_id}`;
            $.get(url,makeModal);
        });
        tr.append(maketd(posting.company), 
        maketd(posting.type),
        maketd(posting.salary));
        
        return tr;
    }
    
    var table = $("#postingTable");
    table.empty(); //removes all children
    
    table.append(makeThead());
    for(posting of data)
    {
        table.append(makeRow(posting));
    }
    
    $('#ack').hide(500);
    $('#postingTable').show(500);
}

// function showDescription(job_id)
// {
//     var url=CONTROLLER_LINK+`?action=showdescription&jobid=${job_id}`;
//       $.get(url,makeModal);
// }

function makeModal(data,status)
{

    var getFormatedDate = (date)=>{
        curr_date = new Date();
        days_ago = (curr_date.getMonth() - date.getMonth())*30 + curr_date.getDate() - date.getDate();
        
        var divide = (days, val, append)=>{
            temp = Math.floor(days/val);
            console.log(temp,append);
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
    $('#jobDescriptionModal .modal-title').text(`${data.company}`);
    $('#type').text(` ${data.type}`);
    $('#salary').text(` ${data.salary}`);

    $('#description').text(data.description);

    // the final one left is to display "Apply Now" Option or "delete post" option
    // $('#jobDescriptionModal .modal-footer a').attr("href",`mailto:${data.email}`);
    modal_footer = $('#jobDescriptionModal .modal-footer');
    modal_footer.find(".btn:first-child").remove();
    // delete option is to be provided for a job_posting if the id in session matches the alumni_id of the posting
    id = $('#session_id').val(); //this has the id value of the session stored
    if(id == data.alumni_id)
    {
        del_option = $('<button></button>').attr("class","btn btn-danger")
                                            .text("Delete Post")
                                            .click(function(){
                                                url = CONTROLLER_LINK+`?action=delpost&job_id=${data.job_id}`;
                                                $.get(url, delPostAck);
                                            });
        modal_footer.prepend(del_option);    
    }
    else
    {
        apply_option = $('<a></a>').attr({
            "href":`mailto:${data.email}`,
            "class":"btn btn-success"
        }).text("Apply Now");
        modal_footer.prepend(apply_option);
    }

    var date_posted = new Date(data.date_posted);
    // process the date to give it as Months-Weeks-Days
    fmt_date = getFormatedDate(date_posted);

    $('#jobDescriptionModal .modal-footer span').text(fmt_date);
}

function postAck(data,status)
{
    if(data)
    {
        console.log("successfully posted");
        $('#post_ack').attr('class','text-success').text('Successfully Posted');
        setup('customview'); //if the job was posted successfully , load the table again to view the Alumni his post
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
        setup('customview');

    }
    else
    {
        console.log('failed to del post');
    }
}