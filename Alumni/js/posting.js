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
    }
}

function makeTable(data, status)
{

    data = JSON.parse(data);

    if(data.length == 0)
    {
        $('#postingTable').hide(500);
        // $('#ack').removeClass("d-none");
        $('#ack').show(500);
        console.log("no data");
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
        
        tr.click(function(){
            showDescription(posting.job_id);
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

function showDescription(job_id)
{
    var url=CONTROLLER_LINK+`?action=showdescription&jobid=${job_id}`;
      $.get(url,makeModal);
}

function makeModal(data,status)
{
    data = JSON.parse(data)[0];
    console.log(data);
    $('#jobDescriptionModal .modal-title').text(`${data.company}`);
    $('#type').text(`Type: ${data.type}`);
    $('#salary').text(`salary: ${data.salary}`);

    $('#description').text(data.description);
    $('#jobDescriptionModal .modal-footer a').attr("href",`mailto:${data.email}`);

    var date=data.date_posted;
    var temp =date.split(" ");
    date = new Date(temp[0]+'T'+temp[1]+'Z');
    $('#jobDescriptionModal .modal-footer span').text(date);
}
