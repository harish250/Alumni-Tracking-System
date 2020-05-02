var CONTROLLER_LINK = "controller.php";

var jq = $.noConflict();

function setup(params)
{
    switch(params)
    {
        case 'upload':
            image_list = document.getElementById('upload_image').files
            
            formdata = new FormData();
            formdata.append('action','upload');
            for(let i=0; i<image_list.length; i++)
            {
                
                formdata.append(i+1, image_list[i], image_list[i].name)
            }
            jq.ajax({
                type: "POST",
                url: CONTROLLER_LINK,
                data: formdata,
                processData: false,
                contentType: false,
                success: function(){
                    setup('viewgallery');
                },
                error: function(errResponse) {
                    console.log(errResponse);
                }   
            });
            break;
        
        case 'viewgallery':
            url = CONTROLLER_LINK+ "?action=getgallery"
            jq.get(url, viewGallery);
    }
}

function viewGallery(data)
{
    data = JSON.parse(data);
    
    gallerycontent= jq("#gallerycontent");
    gallerycontent.empty();
     
    var processImg = (data)=>{
        col = createEle("col-md-3");
        
        a = jq('<a></a>').attr({
            "href":`${data.url}`,
            "data-toggle":"lightbox", 
            "data-gallery":"img-gallery",
            "data-height":"200",
            "data-width":"200"
        });
        
        img = jq('<img/>').attr({"src":`${data.url}`,
                                "class":"img-fluid"})
                            .css({
                                "width":"200px",
                                "height":"200px"
                            });
        
        a.append(img);
        return col.append(a);
    }

    var createEle = (class_)=>
    {
        return jq("<div></div>").addClass(class_);
    }

    var row;
    for(let i=0; i < data.length; i++)
    { 
        if(i%4 == 0)
        {
            row = createEle('row mb-4');
            gallerycontent.append(row);
        }

        row.append(processImg(data[i]));
    }
   

}


/*
var formData = new FormData();

formData.append('name', dogName);
// ... 
formData.append('file', document.getElementById("dogImg").files[0]);


$.ajax({
    type: "POST",
    url: "/foodoo/index.php?method=insertNewDog",
    data: formData,
    processData: false,
    contentType: false,
    success: function(response) {
        console.log(response);
    },
    error: function(errResponse) {
        console.log(errResponse);
    }
});

*/