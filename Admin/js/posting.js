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
    jq("#by").text(`${data.username}`)
    jq('#jobDescriptionModal .modal-title').text(`${data.company}`);
    jq('#type').text(` ${data.type}`);
    jq('#salary').text(` ${data.salary}`);

    jq('#description').text(data.description);

    // the final one left is to display "Apply Now" Option or "delete post" option
    // jq('#jobDescriptionModal .modal-footer a').attr("href",`mailto:${data.email}`);

    var date_posted = new Date(data.date_posted);
    // process the date to give it as Months-Weeks-Days
    fmt_date = getFormatedDate(date_posted);

    jq('#jobDescriptionModal .modal-footer span').text(fmt_date);
}