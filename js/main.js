// Start of Header Functions
const showNav = (el) => {
    let nav = document.getElementById(el);
    if(nav.classList.contains('active')){
        nav.classList.remove('active');
        nav.classList.add('hide');
    } else {
        nav.classList.add('active');
        nav.classList.remove('hide');
    }
};
// End of Header Functions


// Start of Functions for Users page
const editUser = (lid, fname, lname, oname, userEmail, phone, role) => {
  document.getElementById("uid").value = lid;
  document.getElementById("fname").value = fname;
  document.getElementById("lname").value = lname;
  document.getElementById("oname").value = oname;
  document.getElementById("email").value = userEmail;
  document.getElementById("phone").value = phone;
  document.getElementById("role").value = role;
};

const deleteUser = (lid, fname, lname, role) => {
    document.getElementById("duid").value = lid;
    document.getElementById("dfname").value = fname;
    document.getElementById("dlname").value = lname;
    document.getElementById("drole").value = role; 
};

const editStudentCourse = (uid, fname, lname) => {
    document.getElementById("suid").value = uid;
    document.getElementById("sname").value = fname + " " + lname;
};
// End of Functions for Users page

// Start of functions for Faculties page
const editFaculty = (fid, fname) => {
    document.getElementById("efid").value = fid;
    document.getElementById("efname").value = fname;
};

const deleteFaculty = (fid, fname) => {
    document.getElementById("dfid").value = fid;
    document.getElementById("dfname").value = fname;
};
// End of Functions for Faculties page

// Start of Functions for Departments page
const editDepartment = (did, dname, fid) => {
    document.getElementById("edid").value = did;
    document.getElementById("edname").value = dname;
    document.getElementById("efname").value = fid;
};

const deleteDepartment = (did, dname, fname) => {
    document.getElementById("ddid").value = did;
    document.getElementById("ddname").value = dname;
    document.getElementById("dfname").value = fname;
};
// End of Functions for Departments page

// Start of Functions for Courses page
const editCourse = (cid, cname, did) => {
    document.getElementById("ecid").value = cid;
    document.getElementById("ecname").value = cname;
    document.getElementById("edname").value = did;
};

const deleteCourse = (cid, cname) => {
    document.getElementById("dcid").value = cid;
    document.getElementById("dcname").value = cname;
};

const addUnit = (cid, cname) => {
    document.getElementById("ucid").value = cid;
    document.getElementById("ucname").value = cname;
};
// End of Functions for Courses page

// Start of Functions for Units page
const editUnit = (uid, uname, ucode, cid, cname, ubranch, uyear, usem, pvenue) => {
    document.getElementById("euid").value = uid;
    document.getElementById("euname").value = uname;
    document.getElementById("eucode").value = ucode;
    document.getElementById("eucid").value = cid;
    document.getElementById("eucname").value = cname;
    document.getElementById("eubranch").value = ubranch;
    document.getElementById("euyear").value = uyear;
    document.getElementById("eusem").value = usem;
    document.getElementById("eupvenue").value = pvenue;
};

const deleteUnit = (uid, uname, ucode, cname) => {
    document.getElementById("duid").value = uid;
    document.getElementById("duname").value = uname;
    document.getElementById("ducode").value = ucode;
    document.getElementById("ducname").value = cname;
};
// End of Functions for Units page

// Start of Functions for Academic Calendar page
const getSems = () => {
    let yr = document.getElementById("eayear").value;
    let opt = document.getElementById("esem");
    let reg = document.getElementById("reg");
    let act = document.getElementById("act");
    opt.innerHTML = "";
    const url = "./controllers/get-semesters.php?yr="+yr;
        fetch(url)
            .then((resp) => resp.json())
            .then((data) => {
                if(data.data){
                    data.data.forEach((element) => {
                        opt.innerHTML += `<option value ="`+element.id+`">`+element.semester+`</option>`;
                        if(reg != undefined && act != undefined){
                            reg.value = element.registration;
                            act.value = element.active;
                        }
                    });
                }
            });
};
// End of Functions for Academic Calendar

// Start of Functions for Registration
const getRegUnits = (usrid) => {
    const url = "./controllers/get-registration-units.php?usr_id="+usrid;
    fetch(url)
    .then((resp) => resp.json())
    .then((data) => {
        if(data.data) {
            let tb = document.getElementById("regT");
            data.data.forEach((element) => {
                let pre;
                if(element.prerequisites != null){
                    pre = JSON.parse(element.prerequisites);
                    pre.forEach((prereq) => {
                        pre = prereq;
                    });
                } else {
                    pre = {
                        name : "None"
                    }
                }
                tb.innerHTML += `<tr>
                    <td>`+element.code+`</td>
                    <td>`+element.name+`</td>
                    <td>`+element.year+`</td>
                    <td>`+element.sem+`</td>
                    <td>Kshs. `+element.fee+`</td>
                </tr>`;
            });
        }
    });
};

let selectedUnits = [];
const toggleUnit = (id, code, name, fee, course) => {
    let row = document.getElementById("unit"+id);
    let sp = document.getElementById("span"+id);
    if(row.classList.contains("selected")){
        row.classList.remove("selected");
        row.classList.remove("bg-info");
        sp.innerHTML = "Add";
        let i =selectedUnits.findIndex(x => x.id === id);
        if (i !== undefined) selectedUnits.splice(i, 1);
        selectedList();
    } else {
        row.classList.add("selected");
        row.classList.add("bg-info");
        sp.innerHTML = "Remove";
        let un = {
            id : id,
            code : code,
            name : name,
            fee : fee,
            course : course
        };
        selectedUnits.push(un);
        selectedList();
    }
};

const selectedList = () => {
    let tb = document.getElementById("regS");
    let ttd = document.getElementById("uTotal");
    tb.innerHTML = "";
    let tt = 0;
    selectedUnits.forEach((element) => {
        tt += element.fee;
        tb.innerHTML += `<tr>
        <td>`+element.code+`</td>
        <td>`+element.name+`</td>
        <td>Kshs. `+element.fee+`</td>
    </tr>`;
    });
    ttd.innerHTML = `<b>Kshs. `+tt+`</b>`;
};

const registerSem = (usr_id) => {
        const url = "./controllers/create-semester-registration.php";
        d = {
            usr_id: usr_id
        }
        det = {
            method: 'POST',
            headers: new Headers(),
            body: JSON.stringify(d)
        }
        fetch(url, det)
        .then((resp) => resp.json())
        .then((data) => {
            let n = document.getElementById("notify");
            if(data.status == "success"){
                n.innerHTML = `<strong>Alert!</strong> `;
                n.innerHTML += data.message;
                n.style.backgroundColor = "green";
                n.style.color = "white";
                n.classList.remove("hide");
                setTimeout(() => n.classList.add("hide"), 3000);
                setTimeout(() => window.location.assign("./registration.php") , 3000);
                console.log(data);
            } else {
                n.innerHTML = `<strong>Alert!</strong> `;
                n.innerHTML += data.message;
                n.style.backgroundColor = "red";
                n.style.color = "white";
                n.classList.remove("hide");
                setTimeout(() => n.classList.add("hide"), 3000);
                console.log(data);
            }
            console.log(data);
        });
};
// End of Functions for Registrations

// Start of Semester Setup Functions
let courseID;
const setCourseID = (cid) => {
    courseID = cid;
    getRegisteredUnits(courseID);
};
// End of Semester Setup Functions

// Start of Course Timetable Functions
let ttLecturers;

const ttSetCourse = (cid) => {
    ttGetUnits(cid);
    ttGetTTEntries(cid);
};
const getLec = () => {
    const url = "./controllers/get-lecturers.php";
    fetch(url)
    .then((resp) => resp.json())
    .then((data) => {
        ttLecturers = data.data;
    });
}
const ttGetUnits = async (cid) => {
    await getLec();
    const url = "./controllers/get-units.php?cid="+cid;
    let tbl = document.getElementById("ttSelect");
    tbl.innerHTML = "";

    fetch(url)
    .then((resp) => resp.json())
    .then((data) => {
        if(data.data){
            let opt = "";
            ttLecturers.forEach((lec) => {
                let o = `<option value="`+lec.id+`">`+lec.fname+` `+lec.lname+`</option>`;
                opt += o;
            });
            
            data.data.forEach((element) => {
                tbl.innerHTML += `<tr id="unit`+element.id+`" class="">
                    <td>
                        <div class="btn-group-toggle" id="bunit`+element.id+`" data-toggle="buttons" onclick="ttToggleUnit('`+element.id+`', '`+element.code+`', '`+element.name+`', '`+element.duration+`', '`+element.venue+`', '`+element.course+`', '`+element.unitYear+`', '`+element.unitSem+`')">
                            
                                <button type="button" id="span`+element.id+`" class="btn btn-outline-secondary">Add</button>
                            </label>
                        </div>
                    </td>
                    <td>`+element.code+`</td>
                    <td>`+element.name+`</td>
                    <td><select id="sel`+element.id+`" class="form-control">`+opt+`</select></td>
                </tr>`;
            });
        } else {
            console.log("No data received");
        }

    });
};

let ttSelectedUnits = [];
const ttToggleUnit = (id, code, name, dur, ven, cou, uyear, usem) => {
    let row = document.getElementById("unit"+id);
    let bt = document.getElementById("bunit"+id);
    let sp = document.getElementById("span"+id);
    let lc = document.getElementById("sel"+id).value;
    if(bt.classList.contains("selected")){
        bt.classList.remove("selected");
        row.classList.remove("bg-info");
        sp.innerHTML = "Add";
        let i = ttSelectedUnits.findIndex(x => x.id === id);
        if (i !== undefined) ttSelectedUnits.splice(i, 1);
        console.log(ttSelectedUnits);
    } else {
        bt.classList.add("selected");
        row.classList.add("bg-info");
        sp.innerHTML = "Remove";
        let sUn = {
            id : id,
            code : code,
            name : name,
            year : uyear,
            sem : usem,
            course : cou,
            duration : dur,
            venue : ven,
            lecturer : lc
        }
        ttSelectedUnits.push(sUn);
        console.log(ttSelectedUnits);
    }
};

const ttGetTTEntries = (cid) => {
    const url = "./controllers/get-timetables.php?cid="+cid;
};

const genTT = () => {
    if(ttSelectedUnits.length == 0){
        let n = document.getElementById("notify");
        n.innerHTML = `<strong>Alert!</strong> You have to select at least one unit!`;
        n.style.backgroundColor = "red";
        n.style.color = "white";
        n.classList.remove("hide");
        setTimeout(() => n.classList.add("hide"), 5000);
    } else {
        let xTT = 0;
        const xy = () => {
            if(xTT < ttSelectedUnits.length){
                let n = document.getElementById("notify");
                n.innerHTML = `<strong>Alert!</strong> Generating timetable...`;
                n.style.backgroundColor = 'orange';
                n.style.color = 'white';
                n.classList.remove("hide");
                let tSlots = [];
                    let tVenues = [];
                    if(ttSelectedUnits[xTT].venue == 'lab'){
                        tVenues = venues.filter((venu) => {
                            return venu.type === 'lab';
                        });
                    } else if (ttSelectedUnits[xTT].venue == 'room'){
                        tVenues = venues.filter((venu) => {
                            return venu.type === 'room';
        
                        });
                    } else {
                        tVenues = venues.filter((venu) => {
                            return venu.type === 'hall';
                        });
                    }
                    if(ttSelectedUnits[xTT].duration == '3hrs'){
                        tSlots = timeslots.filter((slot) => {
                            return slot.duration === '3hrs';
                        });
                    } else {
                        tSlots = timeslots.filter((slot) => {
                            return slot.duration === '5hrs';
                        });
                    }
                    randas(ttSelectedUnits[xTT].id, ttSelectedUnits[xTT].course, ttSelectedUnits[xTT].lecturer, tVenues, tSlots, ttSelectedUnits[xTT].year, ttSelectedUnits[xTT].sem);
                    xTT += 1;
                    setTimeout(() => {
                        xy();
                    }, 100); 
            }  else {
                let n = document.getElementById("notify");
                n.innerHTML = `<strong>Alert!</strong> All selected units assigned in timetable`;
                n.style.backgroundColor = 'green';
                n.style.color = 'white';
                n.classList.remove("hide");
                setTimeout(() => n.classList.add("hide"), 5000);
                setTimeout(window.location.assign('course-timetable.php'), 7000);
            }
        };
        xy();
    }
}

const randas = (id, cou, lec, ven, tim, year, sem) => {
    let sTT = {
        unit_id : id,
        course_id : cou,
        lecturer_id : lec,
        venue : ven[(Math.floor(Math.random() * ven.length))].id,
        timeslot : tim[(Math.floor(Math.random() * tim.length))].id,
        year : year,
        sem : sem
    }
    console.log("Checking");
    checkTT(sTT.unit_id, sTT.course_id, sTT.lecturer_id, sTT.venue, sTT.timeslot, ven, tim, year, sem);
};

const checkTT = (uid, cid, lec, ven, tim, oVen, oTim, year, sem) => {
    let url = `./controllers/check-timetable-entries2.php?uid=`+uid+`&cid=`+cid+`&lec=`+lec+`&ven=`+ven+`&tim=`+tim+`&ye=`+year+`&sem=`+sem;
    fetch(url)
    .then((resp) => resp.json())
    .then((data) => {
        if(data.status == "success"){
            insertTT(uid, cid, lec, ven, tim, year, sem);
            console.log("Inserting");
            console.log(data);
        } else if (data.status == "error" && data.message == "Unit already registered.") {
            console.log("Unit already registered");
            console.log(data);
        } else if (data.status == "error" && data.message == "Slot is unavailable."){
            console.log("Lecturer or Venue or Timeslot is not available");
            console.log(data);
            randas(uid, cid, lec, oVen, oTim, year, sem);
        } else if (data.status == "error" && data.message == "Error retrieving semester."){
            console.log("Error selecting semester");
            console.log(data);
        } else {
            console.log("Unknown error occured");
            console.log(data);
        }
    });
};

const insertTT = (uid, cid, lec, ven, tim, year, sem) => {
    let url = `./controllers/create-timetable-entry.php?uid=`+uid+`&cid=`+cid+`&lec=`+lec+`&ven=`+ven+`&tim=`+tim+`&year=`+year+`&sem=`+sem;
    fetch(url)
    .then((resp) => resp.json())
    .then((data) => {
        if(data.status == "success"){
            console.log("Inserted successfully");
            console.log(data);
        } else {
            console.log("Insertion failed");
            console.log(data);
        }
    });
};

const popUnits = (course) => {
    const url = "./controllers/get-units.php?cid="+course;
    let sel = document.getElementById("cTTe");
    fetch(url)
    .then((resp) => resp.json())
    .then((data) => {
        if(data.data){
            data.data.forEach((element) => {
                sel.innerHTML += `
                    <option value="`+element.id+`">`+element.name+`</option>
                `;
            });
        } else {

        }
    });
}

const deleteTTEntry = (ttid) => {
    console.log(ttid);
    const url = "./controllers/delete-timetable-entry.php";
    d = {
        tid : ttid
    }
    det = {
        method: 'POST',
        headers: new Headers(),
        body: JSON.stringify(d)
    }
    fetch(url, det)
    .then((resp) => resp.json())
    .then((data) => {
        if(data.status == "success"){
            console.log("Timetable entry deleted successfully");
            setTimeout(window.location.assign("./course-timetable.php"), 1000);
        } else {
            console.log("Error deleting timetable entry");
        }
    });
}

const updateFilter = (opt) => {
    let sel = document.getElementById('ttFilterSel');
    
    if(opt == "none"){
        console.log("Option is none");
    }

    const url = "./controllers/filter-select.php";
    d = {
        filter : opt
    }
    det = {
        method: 'POST',
        headers: new Headers(),
        body: JSON.stringify(d)
    }
    fetch(url, det)
    .then((resp) => resp.json())
    .then((data) => {
        if(data.status == "success"){
            if(opt == "lecturer"){
                sel.innerHTML = "<option value='none'>--Select lecturer--</option>";
                data.data.forEach((element) => {
                    sel.innerHTML += `<option value="`+element.id+`">`+element.fname+` `+element.lname+`</option>`;
                });
            } else if(opt == "venue"){
                sel.innerHTML = "<option value='none'>--Select venue--</option>";
                data.data.forEach((element) => {
                    sel.innerHTML += `<option value="`+element.id+`">`+element.name+`</option>`;
                });
            } else if (opt == "course"){
                sel.innerHTML = "<option value='none'>--Select course--</option>";
                data.data.forEach((element) => {
                    sel.innerHTML += `<option value="`+element.id+`">`+element.name+`</option>`;
                });
            }
        } else {
            sel.innerHTML = "";
            console.log("Error retrieveing filter options");
            console.log(data.status);
            console.log(data.message);
        }
    });
};

const updateTT = (crit, filter) => {
    console.log(crit, filter);

    const url = "./controllers/filter.php";
    d = {
        filter: filter,
        criteria: crit
    }
    det = {
        method: 'POST',
        headers: new Headers(),
        body: JSON.stringify(d)
    }
    fetch(url, det)
    .then((resp) => resp.json())
    .then((data) => {
        document.getElementById('ttList').innerHTML = ttBody;
        giveTThead()
        setTT(data.data);
        console.log(data);
    });

};

// End of Course Timetable Functions

// Start of Registered Units Functions
const dropUnit = (uid, stu, sem) => {
    const url = "./controllers/drop-unit.php";
        d = {
            usr_id: stu,
            uid: uid,
            sem, sem
        }
        det = {
            method: 'POST',
            headers: new Headers(),
            body: JSON.stringify(d)
        }
        fetch(url, det)
        .then((resp) => resp.json())
        .then((data) => {
            if(data.status == "success"){
                setTimeout(window.location.assign("./registered-units.php"), 1000);
            }
            console.log(data);
        });
}
// End of Registered Units Functions

// Start of Toggle Side Bar Function
const toggleSideBar = () => {
    let sd = document.getElementById("side-bar");
    let bars = document.getElementById("bars");
    let container = document.getElementById("container");
    if(sd.classList.contains("active")){
        sd.classList.remove("active");
        sd.style.display = ("none");
        container.style.width = ("100%");
        container.style.marginLeft = ("0px");
        bars.style.display = ("block");
    } else {
        sd.classList.add("active");
        sd.style.display = ("block");
        container.style.width = ("calc(100% - 250px)");
        container.style.marginLeft = ("250px");
        bars.style.display = ("none");
    }
}
// End of Toggle Side Bar Function

// Start Window Resize Event Listener
window.addEventListener("resize", () => {
    let sd = document.getElementById("side-bar");
    let bars = document.getElementById("bars");
    let container = document.getElementById("container");
    if(window.innerWidth <= 600){
        sd.classList.remove("active");
        sd.style.display = ("none");
        container.style.width = ("100%");
        container.style.marginLeft = ("0px");
        bars.style.display = ("block");
    } else {
        sd.classList.add("active");
        sd.style.display = ("block");
        container.style.width = ("calc(100% - 250px)");
        container.style.marginLeft = ("250px");
        bars.style.display = ("none");
    }
});
// End of Window Resize Event Listener

// Start of Toggle Modal
const toggleModal = (id) => {
    let modal = document.getElementById(id);
    if(modal.classList.contains("active")){
        modal.classList.remove("active");
        modal.style.display = "none";
    } else {
        modal.classList.add("active");
        modal.style.display = "block";
    }
}
// End of Toggle Modal

// Start of Tab 
function openTab(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
  
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
  
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
  }
// End of Tab

// Start of Log Functions
const log = (event, element, page) => {
    const url = "./controllers/log.php";
        d = {
            event: event,
            element: element,
            page: page
        }
        det = {
            method: 'POST',
            headers: new Headers(),
            body: JSON.stringify(d)
        }
        fetch(url, det)
        .then((resp) => resp.text())
        .then((data) => {
            //console.log(data);
        });
}
// End of Log Functions


// Start of Submit functions
const onSubmit = (id, url, page, modal) => {
    let params = [];
    params2 = "{";
    let names = [];
    let values = [];
    let form = document.getElementById(id);
    let formInputs = form.getElementsByClassName('form-control');
    for(let x = 0; x < formInputs.length; x++){
        names.push(formInputs[x].name);
        values.push(formInputs[x].value);
    }
    for(let i = 0; i < names.length; i++){
        if(i == names.length - 1) {
            params.push(`"`+names[i]+`": "`+values[i]+`"`);
        } else {
            params.push(`"`+names[i]+`": "`+values[i]+`",`);
        }
    }
    params.forEach((par) => {
        params2 += (JSON.parse(JSON.stringify(par)));
    });
    params2 += "}";

    det = {
        method: 'POST',
        headers: new Headers(),
        body: params2
    }
    fetch(url, det)
    .then((resp) => resp.json())
    .then((data) => {
        let n = document.getElementById("notify");
        if(data.status == "success"){
            toggleModal(modal);
            n.innerHTML = `<strong>Alert!</strong> `;
            n.innerHTML += data.message;
            n.style.backgroundColor = "green";
            n.style.color = "white";
            n.classList.remove("hide");
            setTimeout(() => n.classList.add("hide"), 3000);
            setTimeout(window.location.assign(page), 5000);
            console.log(data);
        } else {
            n.innerHTML = `<strong>Alert!</strong> `;
            n.innerHTML += data.message;
            n.style.backgroundColor = "red";
            n.style.color = "white";
            n.classList.remove("hide");
            setTimeout(() => n.classList.add("hide"), 3000);
            console.log(data);
        }
    });
}

// End of Submit Functions

// Start of System Log Functions
const getLogOptions = (v) => {
    let opt = document.getElementById("selected");
    const url = "./controllers/get-log-options.php";
        d = {
            filter: v
        }
        det = {
            method: 'POST',
            headers: new Headers(),
            body: JSON.stringify(d)
        }
        fetch(url, det)
        .then((resp) => resp.json())
        .then((data) => {
            if(data.status == "success"){
                opt.innerHTML = "<option>-- Select --</option>";
                if(v == "username"){
                    data.data.forEach((element) => {
                        opt.innerHTML += `
                            <option value="`+element.id+`">`+element.name+`</option>
                        `;
                    });
                } else {
                    data.data.forEach((element) => {
                        opt.innerHTML += `
                            <option value="`+element.r+`">`+element.r+`</option>
                        `;
                    });
                }
            } 
            console.log(data.data);
        });
};

const getLogs = () => {
    let filter = document.getElementById("filter").value;
    let selected = document.getElementById("selected").value;
    let page = document.getElementById("page").value;
    let tabl  = document.getElementById("log-table");

    const url = "./controllers/get-logs.php";
        d = {
            filter: filter,
            selected: selected,
            page: page
        }
        det = {
            method: 'POST',
            headers: new Headers(),
            body: JSON.stringify(d)
        }
        fetch(url, det)
        .then((resp) => resp.json())
        .then((data) => {
            if(data.status == "success"){
                tabl.innerHTML = "";
                data.data.forEach(element => {
                    tabl.innerHTML += `
                        <tr>
                            <td>`+element.id+`</td>
                            <td>`+element.name+`</td>
                            <td>`+element.event+`</td>
                            <td>`+element.element+`</td>
                            <td>`+element.page+`</td>
                            <td>`+element.ip_address+`</td>
                            <td>`+element.time+`</td>
                        </tr>
                    `;
                });
                console.log(data);
            } else {
                console.log(data);
            }
        });
};

const getPCount = () => {
    const url = "./controllers/get-page-count.php";
        d = {
            filter: document.getElementById("filter").value,
            criteria: document.getElementById("selected").value
        }
        det = {
            method: 'POST',
            headers: new Headers(),
            body: JSON.stringify(d)
        }
        fetch(url, det)
        .then((resp) => resp.json())
        .then((data) => {
            let pg = document.getElementById("page");
            pg.innerHTML = "";
            let pp = Math.ceil(data.data / 20);
            for(x=0; x<pp; x++){
                pg.innerHTML += `
                    <option value="`+(x+1)+`">`+(x+1)+`</option>
                `;
            }

            console.log(data);
        });
};

const setAndGet = () => {
    getPCount();
    document.getElementById("page").value = 1;
    getLogs();
};
// End of System Log Functions

// Start of FAQs Functions
const showAnswer = (id) => {
   let el = document.getElementsByClassName('activ');
   if(el.length > 0){
       for(i=0; i<el.length; i++){
           el[i].classList.add('hide');
           el[i].classList.remove('activ');
           let x = document.getElementById(id);
            x.classList.remove('hide');
            x.classList.add('activ');
       }
   } else {
       let x = document.getElementById(id);
       x.classList.remove('hide');
       x.classList.add('activ');
   }
};
// End of FAQs Functions

// Start of Chart JS Functions

const bgColors = ['rgba(255, 99, 132, 0.2)',
    'rgba(54, 162, 235, 0.2)',
    'rgba(255, 206, 86, 0.2)',
    'rgba(75, 192, 192, 0.2)',
    'rgba(153, 102, 255, 0.2)',
    'rgba(255, 159, 64, 0.2)', 
    'rgba(0,0,255,0.2)', 
    'rgba(0,128,128,0.2)'];
const bdColors = ['rgba(255, 99, 132, 1)',
    'rgba(54, 162, 235, 1)',
    'rgba(255, 206, 86, 1)',
    'rgba(75, 192, 192, 1)',
    'rgba(153, 102, 255, 1)',
    'rgba(255, 159, 64, 1)', 
    'rgba(0,0,255,1)', 
    'rgba(0,128,128,1)'];

const drawChart = (canvas, chType, labels, dataLabels, data, Xaxes, Yaxes) => {
    let ctx = document.getElementById(canvas).getContext('2d');
    let myChart = new Chart(ctx, {
        type: chType,
        data: {
            labels: labels,
            datasets: [{
                label: dataLabels,
                data: data,
                backgroundColor: bgColors,
                borderColor: bdColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: false,
            scales: {
                yAxes: [{
                    display: Yaxes,
                    ticks: {
                        beginAtZero: true
                    }
                }],
                xAxes: [{
                    display: Xaxes,
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
}
// End of Chart JS Functions


// Start of Timetable
function giveTThead() {
    let tr = `<tr>
            <th>0700</th>
            <th>0800</th>
            <th>0900</th>
            <th>1000</th>
            <th>1100</th>
            <th>1200</th>
            <th>1300</th>
            <th>1400</th>
            <th>1500</th>
            <th>1600</th>
            <th>1700</th>
        </tr>`;
    let th = ['th1', 'th2', 'th3', 'th4', 'th5'];
    let tb = ['tmon', 'ttue', 'twed', 'tthu', 'tfri'];
    th.forEach((thew) => {
        let x = document.getElementById(thew);
        x.innerHTML = tr;
    });
}


let ttBody = `
<li>
<h3>Monday</h3><hr>
<table class="table shadow table-bordered">
  <thead id="th1" class="thead-dark">
      
  </thead>
  <tbody id="tmon">
      <tr>
          <td></td>
          <td colspan="3" id="tmon8"></td>
          <td colspan="3" id="tmon11"></td>
          <td colspan="3" id="tmon2"></td>
          <td></td>
      </tr>
  </tbody>
</table>
</li>
<li>
<h3>Tuesday</h3><hr>
<table class="table shadow table-bordered">
  <thead id="th2" class="thead-dark">
      
  </thead>
  <tbody id="ttue">
  <tr>
      <td></td>
      <td colspan="3" id="ttue8"></td>
      <td colspan="3" id="ttue11"></td>
      <td colspan="3" id="ttue2"></td>
      <td></td>
      </tr>
  </tbody>
</table>
</li>
<li>
<h3>Wednesday</h3><hr>
<table class="table shadow table-bordered">
  <thead id="th3" class="thead-dark">
      
  </thead>
  <tbody id="twed">
  <tr>
      <td></td>
      <td colspan="3" id="twed8"></td>
      <td colspan="3" id="twed11"></td>
      <td colspan="3" id="twed2"></td>
      <td></td>
      </tr>
  </tbody>
</table>
</li>
<li>
<h3>Thursday</h3><hr>
<table class="table shadow table-bordered">
  <thead id="th4" class="thead-dark">
      
  </thead>
  <tbody id="tthu">
  <tr>
      <td></td>
      <td colspan="3" id="tthu8"></td>
      <td colspan="3" id="tthu11"></td>
      <td colspan="3" id="tthu2"></td>
      <td></td>
      </tr>
  </tbody>
</table>
</li>
<li>
<h3>Friday</h3><hr>
<table class="table shadow table-bordered">
  <thead id="th5"class="thead-dark">
      
  </thead>
  <tbody id="tfri">
  <tr>
      <td></td>
      <td colspan="3" id="tfri8"></td>
      <td colspan="3" id="tfri11"></td>
      <td colspan="3" id="tfri2"></td>
      <td></td>
      </tr>
  </tbody>
</table>
</li>
`;



function setTT(t){
    t.forEach((tim) => {
        if(tim.day == 'monday'){
            if(tim.start == '8am'){
                let y = document.getElementById('tmon8');
                y.innerHTML += `
                <div class="ttCard">
                    <div class="ttCardHead">
                        <div class="ttCode"><h3>`+tim.code+`</h3></div>
                        <div class="ttTitle"><h3>`+tim.unit+`</h3></div>
                    </div>
                    <div class="ttVenue">`+tim.venue+`</div>
                    <div class="ttVenue">`+tim.start+` - `+tim.end+`</div>
                    <div class="ttLec">`+tim.lecturer+`</div>
                    <div class="ttOpt">
                        <button type="button" class="btn btn-outline-danger" onclick="deleteTTEntry(`+tim.id+`); log('action', 'Delete timetable entry `+tim.unit+`', window.location.href);"><i class=\"fas fa-trash\"></i></button>
                    </div>
                </div>`;
            } else if(tim.start == '11am'){
                let y = document.getElementById('tmon11');
                y.innerHTML += `
                <div class="ttCard">
                    <div class="ttCardHead">
                        <div class="ttCode"><h3>`+tim.code+`</h3></div>
                        <div class="ttTitle"><h3>`+tim.unit+`</h3></div>
                    </div>
                    <div class="ttVenue">`+tim.venue+`</div>
                    <div class="ttVenue">`+tim.start+` - `+tim.end+`</div>
                    <div class="ttLec">`+tim.lecturer+`</div>
                    <div class="ttOpt">
                        <button type="button" class="btn btn-outline-danger" onclick="deleteTTEntry(`+tim.id+`); log('action', 'Delete timetable entry `+tim.unit+`', window.location.href);"><i class=\"fas fa-trash\"></i></button>
                    </div>
                </div>`;
            } else if(tim.start == '2pm'){
                let y = document.getElementById('tmon2');
                y.innerHTML += `
                <div class="ttCard">
                    <div class="ttCardHead">
                        <div class="ttCode"><h3>`+tim.code+`</h3></div>
                        <div class="ttTitle"><h3>`+tim.unit+`</h3></div>
                    </div>
                    <div class="ttVenue">`+tim.venue+`</div>
                    <div class="ttVenue">`+tim.start+` - `+tim.end+`</div>
                    <div class="ttLec">`+tim.lecturer+`</div>
                    <div class="ttOpt">
                        <button type="button" class="btn btn-outline-danger" onclick="deleteTTEntry(`+tim.id+`); log('action', 'Delete timetable entry `+tim.unit+`', window.location.href);"><i class=\"fas fa-trash\"></i></button>
                    </div>
                </div>`;
            }
        } else if(tim.day == 'tuesday'){
            if(tim.start == '8am'){
                let y = document.getElementById('ttue8');
                y.innerHTML += `
                <div class="ttCard">
                    <div class="ttCardHead">
                        <div class="ttCode"><h3>`+tim.code+`</h3></div>
                        <div class="ttTitle"><h3>`+tim.unit+`</h3></div>
                    </div>
                    <div class="ttVenue">`+tim.venue+`</div>
                    <div class="ttVenue">`+tim.start+` - `+tim.end+`</div>
                    <div class="ttLec">`+tim.lecturer+`</div>
                    <div class="ttOpt">
                        <button type="button" class="btn btn-outline-danger" onclick="deleteTTEntry(`+tim.id+`); log('action', 'Delete timetable entry `+tim.unit+`', window.location.href);"><i class=\"fas fa-trash\"></i></button>
                    </div>
                </div>`;
            } else if(tim.start == '11am'){
                let y = document.getElementById('ttue11');
                y.innerHTML += `
                <div class="ttCard">
                    <div class="ttCardHead">
                        <div class="ttCode"><h3>`+tim.code+`</h3></div>
                        <div class="ttTitle"><h3>`+tim.unit+`</h3></div>
                    </div>
                    <div class="ttVenue">`+tim.venue+`</div>
                    <div class="ttVenue">`+tim.start+` - `+tim.end+`</div>
                    <div class="ttLec">`+tim.lecturer+`</div>
                    <div class="ttOpt">
                        <button type="button" class="btn btn-outline-danger" onclick="deleteTTEntry(`+tim.id+`); log('action', 'Delete timetable entry `+tim.unit+`', window.location.href);"><i class=\"fas fa-trash\"></i></button>
                    </div>
                </div>`;
            } else if(tim.start == '2pm'){
                let y = document.getElementById('ttue2');
                y.innerHTML += `
                <div class="ttCard">
                    <div class="ttCardHead">
                        <div class="ttCode"><h3>`+tim.code+`</h3></div>
                        <div class="ttTitle"><h3>`+tim.unit+`</h3></div>
                    </div>
                    <div class="ttVenue">`+tim.venue+`</div>
                    <div class="ttVenue">`+tim.start+` - `+tim.end+`</div>
                    <div class="ttLec">`+tim.lecturer+`</div>
                    <div class="ttOpt">
                        <button type="button" class="btn btn-outline-danger" onclick="deleteTTEntry(`+tim.id+`); log('action', 'Delete timetable entry `+tim.unit+`', window.location.href);"><i class=\"fas fa-trash\"></i></button>
                    </div>
                </div>`;
            }
        } else if(tim.day == 'wednesday'){
            if(tim.start == '8am'){
                let y = document.getElementById('twed8');
                y.innerHTML += `
                <div class="ttCard">
                    <div class="ttCardHead">
                        <div class="ttCode"><h3>`+tim.code+`</h3></div>
                        <div class="ttTitle"><h3>`+tim.unit+`</h3></div>
                    </div>
                    <div class="ttVenue">`+tim.venue+`</div>
                    <div class="ttVenue">`+tim.start+` - `+tim.end+`</div>
                    <div class="ttLec">`+tim.lecturer+`</div>
                    <div class="ttOpt">
                        <button type="button" class="btn btn-outline-danger" onclick="deleteTTEntry(`+tim.id+`); log('action', 'Delete timetable entry `+tim.unit+`', window.location.href);"><i class=\"fas fa-trash\"></i></button>
                    </div>
                </div>`;
            } else if(tim.start == '11am'){
                let y = document.getElementById('twed11');
                y.innerHTML += `
                <div class="ttCard">
                    <div class="ttCardHead">
                        <div class="ttCode"><h3>`+tim.code+`</h3></div>
                        <div class="ttTitle"><h3>`+tim.unit+`</h3></div>
                    </div>
                    <div class="ttVenue">`+tim.venue+`</div>
                    <div class="ttVenue">`+tim.start+` - `+tim.end+`</div>
                    <div class="ttLec">`+tim.lecturer+`</div>
                    <div class="ttOpt">
                        <button type="button" class="btn btn-outline-danger" onclick="deleteTTEntry(`+tim.id+`); log('action', 'Delete timetable entry `+tim.unit+`', window.location.href);"><i class=\"fas fa-trash\"></i></button>
                    </div>
                </div>`;
            } else if(tim.start == '2pm'){
                let y = document.getElementById('twed2');
                y.innerHTML += `
                <div class="ttCard">
                    <div class="ttCardHead">
                        <div class="ttCode"><h3>`+tim.code+`</h3></div>
                        <div class="ttTitle"><h3>`+tim.unit+`</h3></div>
                    </div>
                    <div class="ttVenue">`+tim.venue+`</div>
                    <div class="ttVenue">`+tim.start+` - `+tim.end+`</div>
                    <div class="ttLec">`+tim.lecturer+`</div>
                    <div class="ttOpt">
                        <button type="button" class="btn btn-outline-danger" onclick="deleteTTEntry(`+tim.id+`); log('action', 'Delete timetable entry `+tim.unit+`', window.location.href);"><i class=\"fas fa-trash\"></i></button>
                    </div>
                </div>`;
            }
        } else if(tim.day == 'thursday'){
            if(tim.start == '8am'){
                let y = document.getElementById('tthu8');
                y.innerHTML += `
                <div class="ttCard">
                    <div class="ttCardHead">
                        <div class="ttCode"><h3>`+tim.code+`</h3></div>
                        <div class="ttTitle"><h3>`+tim.unit+`</h3></div>
                    </div>
                    <div class="ttVenue">`+tim.venue+`</div>
                    <div class="ttVenue">`+tim.start+` - `+tim.end+`</div>
                    <div class="ttLec">`+tim.lecturer+`</div>
                    <div class="ttOpt">
                        <button type="button" class="btn btn-outline-danger" onclick="deleteTTEntry(`+tim.id+`); log('action', 'Delete timetable entry `+tim.unit+`', window.location.href);"><i class=\"fas fa-trash\"></i></button>
                    </div>
                </div>`;
            } else if(tim.start == '11am'){
                let y = document.getElementById('tthu11');
                y.innerHTML += `
                <div class="ttCard">
                    <div class="ttCardHead">
                        <div class="ttCode"><h3>`+tim.code+`</h3></div>
                        <div class="ttTitle"><h3>`+tim.unit+`</h3></div>
                    </div>
                    <div class="ttVenue">`+tim.venue+`</div>
                    <div class="ttVenue">`+tim.start+` - `+tim.end+`</div>
                    <div class="ttLec">`+tim.lecturer+`</div>
                    <div class="ttOpt">
                        <button type="button" class="btn btn-outline-danger" onclick="deleteTTEntry(`+tim.id+`); log('action', 'Delete timetable entry `+tim.unit+`', window.location.href);"><i class=\"fas fa-trash\"></i></button>
                    </div>
                </div>`;
            } else if(tim.start == '2pm'){
                let y = document.getElementById('tthu2');
                y.innerHTML += `
                <div class="ttCard">
                    <div class="ttCardHead">
                        <div class="ttCode"><h3>`+tim.code+`</h3></div>
                        <div class="ttTitle"><h3>`+tim.unit+`</h3></div>
                    </div>
                    <div class="ttVenue">`+tim.venue+`</div>
                    <div class="ttVenue">`+tim.start+` - `+tim.end+`</div>
                    <div class="ttLec">`+tim.lecturer+`</div>
                    <div class="ttOpt">
                        <button type="button" class="btn btn-outline-danger" onclick="deleteTTEntry(`+tim.id+`); log('action', 'Delete timetable entry `+tim.unit+`', window.location.href);"><i class=\"fas fa-trash\"></i></button>
                    </div>
                </div>`;
            }
        } else if(tim.day == 'friday'){
            if(tim.start == '8am'){
                let y = document.getElementById('tfri8');
                y.innerHTML += `
                <div class="ttCard">
                    <div class="ttCardHead">
                        <div class="ttCode"><h3>`+tim.code+`</h3></div>
                        <div class="ttTitle"><h3>`+tim.unit+`</h3></div>
                    </div>
                    <div class="ttVenue">`+tim.venue+`</div>
                    <div class="ttVenue">`+tim.start+` - `+tim.end+`</div>
                    <div class="ttLec">`+tim.lecturer+`</div>
                    <div class="ttOpt">
                        <button type="button" class="btn btn-outline-danger" onclick="deleteTTEntry(`+tim.id+`); log('action', 'Delete timetable entry `+tim.unit+`', window.location.href);"><i class=\"fas fa-trash\"></i></button>
                    </div>
                </div>`;
            } else if(tim.start == '11am'){
                let y = document.getElementById('tfri11');
                y.innerHTML += `
                <div class="ttCard">
                    <div class="ttCardHead">
                        <div class="ttCode"><h3>`+tim.code+`</h3></div>
                        <div class="ttTitle"><h3>`+tim.unit+`</h3></div>
                    </div>
                    <div class="ttVenue">`+tim.venue+`</div>
                    <div class="ttVenue">`+tim.start+` - `+tim.end+`</div>
                    <div class="ttLec">`+tim.lecturer+`</div>
                    <div class="ttOpt">
                        <button type="button" class="btn btn-outline-danger" onclick="deleteTTEntry(`+tim.id+`); log('action', 'Delete timetable entry `+tim.unit+`', window.location.href);"><i class=\"fas fa-trash\"></i></button>
                    </div>
                </div>`;
            } else if(tim.start == '2pm'){
                let y = document.getElementById('tfri2');
                y.innerHTML += `
                <div class="ttCard">
                    <div class="ttCardHead">
                        <div class="ttCode"><h3>`+tim.code+`</h3></div>
                        <div class="ttTitle"><h3>`+tim.unit+`</h3></div>
                    </div>
                    <div class="ttVenue">`+tim.venue+`</div>
                    <div class="ttVenue">`+tim.start+` - `+tim.end+`</div>
                    <div class="ttLec">`+tim.lecturer+`</div>
                    <div class="ttOpt">
                        <button type="button" class="btn btn-outline-danger" onclick="deleteTTEntry(`+tim.id+`); log('action', 'Delete timetable entry `+tim.unit+`', window.location.href);"><i class=\"fas fa-trash\"></i></button>
                    </div>
                </div>`;
            }
        }
    });
}

// End of Timetable