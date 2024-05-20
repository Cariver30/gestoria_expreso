/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: project create Init Js File
*/

// Form Event
(function () {
    'use strict'

    var forms = document.querySelectorAll('.needs-validation');
    var itemid = 10;
    // form date picker
    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    // $('#duedate-input').datepicker('setDate', today);



    var editinputValueJson = sessionStorage.getItem('editInputValue');
    if (editinputValueJson) {
        var editinputValueJson = JSON.parse(editinputValueJson);
        document.getElementById("formAction").value = "edit";
        document.getElementById("project-id-input").value = editinputValueJson.id;
        document.getElementById("projectlogo-img").src = editinputValueJson.projectLogoImg;
        document.getElementById("projectname-input").value = editinputValueJson.projectTitle;
        document.getElementById("projectdesc-input").value = editinputValueJson.projectDesc;
        document.getElementById("project-status-input").value = editinputValueJson.status;
        // $('#duedate-input').datepicker('setDate', editinputValueJson.dueDate);

        Array.from(document.querySelectorAll("#select-element .dropdown-menu ul li a")).forEach(function (subElem) {
            var nameelem = subElem.querySelector(".flex-grow-1").innerHTML;

            editinputValueJson.assignedto.map(function (subItem) {
                if (subItem.assigneeName == nameelem) {
                    subElem.classList.add("active");
                    var assigneeListdata = document.getElementById("assignee-member");
                    if (subElem.classList.contains("active")) {
                        var memberlisthtml =
                            '<a href="javascript: void(0);" class="avatar-group-item mb-2" data-img="' + subItem.assigneeImg + '"  data-bs-toggle="tooltip" data-bs-placement="top" title="' + subItem.assigneeName + '">\
                        <img src="'+ subItem.assigneeImg + '" alt="" class="rounded-circle avatar-xs" />\
                        </a>';

                        assigneeListdata.insertAdjacentHTML("beforeend", memberlisthtml);
                    }
                }

                return subElem;
            });
        });

        var assigneelength = document.querySelectorAll('#select-element .dropdown-menu .dropdown-item.active').length;
        document.getElementById("total-assignee").innerHTML = assigneelength
    }

    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    event.preventDefault();
                    itemid++;
                    var projectItemID = itemid;
                    var projectNameVal = document.getElementById("projectname-input").value;
                    var projectDescVal = document.getElementById("projectdesc-input").value;
                    var projectLogoImg = document.getElementById("projectlogo-img").src;
                    var statusInput = document.getElementById('project-status-input').value;
                    var dueDateInput = document.getElementById('duedate-input').value;
                    var assignedtousers = []
                    var assignedTo = document.querySelectorAll('#select-element .assignto-list li a.active');
                    if (assignedTo.length > 0) {
                        Array.from(assignedTo).forEach(function (ele) {
                            var imgpath = ele.querySelector(".avatar-xs img").getAttribute('src');
                            var namepath = ele.querySelector(".flex-grow-1").innerHTML;
                            var obj = {};
                            obj["assigneeName"] = namepath
                            obj["assigneeImg"] = imgpath
                            assignedtousers.push(obj);
                        });
                    }
                    var formAction = document.getElementById("formAction").value;

                    if (formAction == "add") {
                        if (sessionStorage.getItem('inputValue') != null) {
                            var inputValueJson = JSON.parse(sessionStorage.getItem('inputValue'));
                            var newObj = {
                                "id": projectItemID + 1,
                                "projectLogoImg": projectLogoImg,
                                "projectTitle": projectNameVal,
                                "projectDesc": projectDescVal,
                                "dueDate": dueDateInput,
                                "status": statusInput,
                                "assignedto": assignedtousers
                            };
                            inputValueJson.push(newObj);
                            sessionStorage.setItem('inputValue', JSON.stringify(inputValueJson));
                        } else {
                            var inputValueJson = [];
                            var newObj = {
                                "id": projectItemID,
                                "projectLogoImg": projectLogoImg,
                                "projectTitle": projectNameVal,
                                "projectDesc": projectDescVal,
                                "dueDate": dueDateInput,
                                "status": statusInput,
                                "assignedto": assignedtousers
                            };
                            inputValueJson.push(newObj);
                            sessionStorage.setItem('inputValue', JSON.stringify(inputValueJson));
                        }
                    } else if (formAction == "edit") {
                        var editproductId = document.getElementById("project-id-input").value;
                        if (sessionStorage.getItem('editInputValue')) {
                            var editObj = {
                                "id": parseInt(editproductId),
                                "projectLogoImg": projectLogoImg,
                                "projectTitle": projectNameVal,
                                "projectDesc": projectDescVal,
                                "dueDate": dueDateInput,
                                "status": statusInput,
                                "assignedto": assignedtousers
                            }
                            sessionStorage.setItem('editInputValue', JSON.stringify(editObj));
                        }
                    } else {
                        console.log('Form Action Not Found.');
                    }
                    window.location.replace("projects-list");
                    return false;
                }
                form.classList.add('was-validated');
            }, false);
        });

    // Agregar usuario
    Array.from(document.querySelectorAll("#select-element .assignto-list li a")).forEach(function (subElem) {
        subElem.addEventListener("click", function () {
            subElem.classList.toggle("active");
            var assigneeMember = document.querySelectorAll('#select-element .assignto-list li a.active');
            document.getElementById("total-assignee").innerHTML = assigneeMember.length;

            var imgPath = subElem.querySelector(".avatar-xs img").getAttribute('src');
            var idPath = subElem.querySelector(".avatar-xs img").getAttribute('id');
            var assigneeListdata = document.getElementById("assignee-member");
            if (subElem.classList.contains("active")) {
                var nameelem = subElem.querySelector(".flex-grow-1").innerHTML;
                var memberlisthtml =
                    '<a href="javascript: void(0);" class="avatar-group-item mb-2" data-img="' + idPath + '"  data-bs-toggle="tooltip" data-bs-placement="top" title="' + nameelem + '">\
                        <img src="'+ imgPath + '" alt="" class="rounded-circle avatar-xs" />\
                    </a>';
                assigneeListdata.insertAdjacentHTML("beforeend", memberlisthtml);
            } else {
                Array.from(assigneeListdata.querySelectorAll(".avatar-group-item")).forEach(function (item) {
                    var avatarImg = item.getAttribute('data-img');
                    if (idPath == avatarImg) {
                        item.remove();
                    }
                });
            }
            tooltipElm()
        });
    });

    // Editar usuario
    Array.from(document.querySelectorAll("#select-entidad .entidad-list li a")).forEach(function (subElem) {
        subElem.addEventListener("click", function () {
            subElem.classList.toggle("active");
            var assigneeMember = document.querySelectorAll('#select-entidad .entidad-list li a.active');
            document.getElementById("total-entidades").innerHTML = assigneeMember.length;
            var imgPath = subElem.querySelector(".avatar-xs-up img").getAttribute('src');
            var idPath = subElem.querySelector(".avatar-xs-up img").getAttribute('id');
            var listEntidades = document.getElementById("usuario-entidad");
            if (subElem.classList.contains("active")) {
                var nameelem = subElem.querySelector(".flex-grow-2").innerHTML;
                var memberlisthtml =
                    '<a href="javascript: void(0);" class="avatar-group-item-up mb-2" data-img="' + idPath + '"  data-bs-toggle="tooltip" data-bs-placement="top" title="' + nameelem + '">\
                        <img src="'+ imgPath + '" alt="" class="rounded-circle avatar-xs avatar-xs-up" />\
                    </a>';
                listEntidades.insertAdjacentHTML("beforeend", memberlisthtml);
            } else {
                Array.from(listEntidades.querySelectorAll(".avatar-group-item-up")).forEach(function (item) {
                    var avatarImg = item.getAttribute('data-img');
                    if (idPath == avatarImg) {
                        item.remove();
                    }
                });
            }
            tooltipElm()
        });
    });

    function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

    function tooltipElm() {
        var tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        var tooltipList = [].concat(_toConsumableArray(tooltipTriggerList)).map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
})()