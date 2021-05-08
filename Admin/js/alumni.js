var CONTROLLER_LINK = "controller.php";

jq = $.noConflict();

function setup(param) {
  switch (param) {
    case "search":
      val = jq("#searchinput").val();
      val = val.replace(" ", "_");
      url = CONTROLLER_LINK + `?action=search&val=${val}`;
      jq.get(url, showAlumnies);
  }
}

function pressSearchBtn(event) {
  if (event.keyCode === 13) {
    event.preventDefault();
    document.getElementById("searchbtn").click();
  }
}

function showAlumnies(data, status) {
  if (status === "success") {
    data = JSON.parse(data);
    var n_cards = 3;

    var createEle = (class_) => {
      return jq("<div></div>").addClass(class_);
    };

    content = jq("#alumnicontent");
    content.empty();
    var row;
    for (let i = 0; i < data.length; i++) {
      if (i % n_cards == 0) {
        row = createEle("row");
        content.append(row);
      }
      card = createCard(data[i]);
      row.append(card);
    }
  }

  function createCard(data) {
    var val = parseInt(12 / n_cards);

    card = createEle(`col-md-${val} card mb-3 mt-5 p-1`);

    // onclick-- particularalumni
    body = createEle("card-body")
      .attr({
        "data-toggle": "modal",
        "data-target": "#alumniModal",
      })
      .click(function () {
        url = CONTROLLER_LINK + `?action=particularalumni&id=${data.alumni_id}`;
        jq.get(url, createAlumniModal);
      });
    footer = createEle("card-footer");
    title = createEle("card-title").text(`${data.username}`).addClass("mb-0");

    subtitle = createEle("card-subtitle")
      .text(`${data.batch_year} Batch`)
      .addClass("mb-3 text-muted");

    card_text = createEle("card-text").text(`${data.company} | `);

    small = jq("<small></small>")
      .text(`${data.designation}`)
      .addClass("text-muted");
    card_text.append(small);
    connect = jq("<a></a>")
      .addClass("btn btn-lg btn-outline-success")
      .attr({
        "data-toggle": "modal",
        "data-target": "#connectModal",
      })
      .text("Connect")
      .click(function () {
        url = CONTROLLER_LINK + `?action=contactinfo&id=${data.alumni_id}`;

        jq.get(url, createConnectModal);
      });
    footer.append(connect);
    body.append(title, subtitle, card_text);

    return card.append(body, footer);
  }
}

function createConnectModal(data, status) {
  if (status === "success") {
    data = JSON.parse(data);
    modal = jq("#connectModal");

    jq("#call_btn").attr("href", `tel:${data.phno}`); //need to put phno
    jq("#mail_btn").attr("href", `mailto:${data.email}`);
  }
}

function createAlumniModal(data, status) {
  if (status === "success") {
    data = JSON.parse(data)[0];
    console.log(data);

    jq("#roll").text(data.alumni_id);

    jq("#branch").text(`${data.branch}  ${data.batch_year}`);
    jq("#alumniModal .modal-title").text(data.username);
    jq("#company").text(data.company);
    jq("#address").text(data.address);
    if (!data.n_imgs) {
      jq("#img").text(0);
    } else {
      jq("#img").text(data.n_imgs);
    }

    if (!data.n_posting) {
      jq("#posting").text(0);
    } else {
      jq("#posting").text(data.n_posting);
    }
  }
}
