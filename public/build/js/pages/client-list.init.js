var url = "get/data/clientes";
var urlImagen = "images/expreso.jpeg";
var allClientList = '';

//Job list by json
var getJSON = function (jsonurl, callback) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", url, true);
    xhr.responseType = "json";
    xhr.onload = function () {
        var status = xhr.status;
        if (status === 200) {
            callback(null, xhr.response);
        } else {
            callback(status, xhr.response);
        }
    };
    xhr.send();
};

// get json
getJSON(url, function (err, data) {
    if (err !== null) {
        console.log("Something went wrong: " + err);
    } else {
        loadClientListData(data);
    }
});


function loadClientListData(datas) {
    document.querySelector("#client-list").innerHTML = '';
    if (datas.length == 0) {
        document.querySelector("#client-list").innerHTML += '<div class="col-xl-12 col-md-6">\
        <div class="card">\
                <div class="card-body text-center">\
                    SIN CLIENTES DISPONIBLES\
                    </div>\
                </div>\
            </div>\
        </div>';
    } else {
        Array.from(datas).forEach(function (listData, index) {
            document.querySelector("#client-list").innerHTML += '<div class="col-xl-3 col-md-6">\
            <div class="card">\
                <div class="card-body text-center">\
                    <div class="favorite-icon">\
                        <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>\
                    </div>\
                    <img src="'+ urlImagen +'" alt="" height="50" class="mb-3">\
                    <h5 class="fs-17 mb-2"><a href="" class="text-dark"> '+listData.nombre+' </a></h5>\
                    <small>'+listData.seguro_social+'</small><br>\
                    '+isType(listData.estatus_id)+'\
                    <div class="mt-4">\
                        <a href="clientes/'+listData.id+'/edit" class="btn btn-soft-primary d-block"> Ver Detalle </a>\
                    </div>\
                </div>\
            </div>\
        </div>';
        });
    }
}

function isType(val) {
    switch (val) {
        case 1:
            return ('<span class="badge badge-soft-success">' + val + "</span>");
        case 2:
            return ('<span class="badge badge-soft-info">' + val + "</span>");
        case 3:
            return ('<span class="badge bg-success"> En curso </span>');
        case 4:
            return ('<span class="badge bg-success"> Activo </span>');
        case 5:
            return ('<span class="badge badge-soft-warning">Pendiente</span>');
    }
}

// Filtro por Seguro Social
$('.search_seguro_social').change(function(){
    var valor = $(this).val();
    $.get('get/data/clientes/search/' + valor, function (datas) {
        loadClientListData(datas);
    });
});

//Filtro por tablilla
$('.search_tablilla').change(function(){
    var valor = $(this).val();
    $.get('get/data/clientes/search/' + valor, function (datas) {
        loadClientListData(datas);
    });
});

// Filtrado por mes de vencimiento
$('.search_mes_vencimiento').change(function(){
    var valor = $(this).val();
    $.get('get/data/clientes/search/' + valor, function (datas) {
        loadClientListData(datas);
    });
});

// Ver todos
function verTodos() {
    $.get(url, function (datas) {
        loadClientListData(datas);
    });
}

// Search list
// var searchElementList = document.getElementById("search_seguro_social");
// searchElementList.addEventListener("keyup", function () {
//     var inputVal = searchElementList.value.toLowerCase();
//     function filterItems(arr, query) {
//         return arr.filter(function (el) {
//             return el.candidateName.toLowerCase().indexOf(query.toLowerCase()) !== -1
//         })
//     }

//     var filterData = filterItems(allCandidateList, inputVal);
//     loadClientListData(filterData)
// });

// function filterData() {
//     var typeVal = document.getElementById("idType").value;
//     var pickerVal = document.querySelector("#datepicker1 input").value;

//     var filterData = allCandidateList.filter(function (data) {
//         var typeFilter = false;
//         var dateFilter = false;
//         if (data.type == "all" || typeVal == "all") {
//             typeFilter = true;
//         } else {
//             typeFilter = data.type == typeVal;
//         }

//         if (new Date(data.createDate) <= new Date(pickerVal)) {
//             dateFilter = true;
//         } else {
//             dateFilter = false;
//         }

//         if (typeFilter && dateFilter) {
//             return typeFilter && dateFilter;
//         }
//     });

//     loadClientListData(filterData);
// }