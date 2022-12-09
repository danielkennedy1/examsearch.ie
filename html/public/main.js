//TODO make this uncallable from console

//(() =>{console.log("anon")})(/*dependancy list*/);
const url = 'http://127.0.0.1:8000';
let EXAM = "";
let SUBJECT = "";
let YEAR;
let LANG = "";
let LVL = "";
let subjects = [];
let years = [];
let examList = [];
let markList = [];


// Full name of exam from value
const examDict = {
    "lc": "Leaving Certificate",
    "jc": "Junior Certificate",
    "lca": "Leaving Certificate Applied"
};
// Full name of type from value
const typeDict = {
    "exam": "Exam Papers",
    "mark": "Marking Schemes",
};
//Get rid of the years (used for new subject)
const clearYears = (disabled) => {
    years = [];
    document.getElementById("yearSelect").innerHTML = "Select Year";
    document.getElementById("yearSelect").disabled = disabled;
    document.getElementById("yearList").innerHTML = "";
};

const examDropdown = document.getElementById("examDropdown");
const searchBar = document.getElementById("searchBar");
//called when exam is chosen
const getSubjects = (_exam) => {
    EXAM = _exam;
    //clear list of subjects, and subject text input
    if (subjects.length > 0) subjects = [];
    searchBar.value = "";
    clearYears(true);
    //fetch subjects from api
    axios.get(`${url}/api/` + _exam)
        .then(function(response) {
            response.data.forEach(subject => {
                subjects.push(subject);
            });
            //update GUI state, to allow for subject search
            examDropdown.innerHTML = examDict[_exam];
            searchBar.disabled = false;
            //reset autocomplete options for subject search
            autocomplete(searchBar, subjects);
        });
};

//called when subject is chosen
const getYears = (subject) => {
    //update global subject variable
    SUBJECT = subject;
    //clear list of years
    clearYears(false);
    const yearSelector = document.getElementById("yearSelect");
    const yearList = document.getElementById("yearList");
    //fetch years from api
    axios.get(`${url}/api/${EXAM}/${subject}`).then(function(response) {
        response.data.forEach(year => {
            years.push(year);
        });
        //update GUI state, to allow for year search
        yearSelector.classList.remove("btn-outline-secondary");
        yearSelector.classList.add("btn-primary");
        years.forEach(year => {
            const option = document.createElement("a");
            option.onclick = () => {
                getMaterials(year);
            };
            option.innerHTML = year;
            option.classList.add("dropdown-item");
            yearList.appendChild(option);
        });
    });
};

//called when autocomplete option is selected
//point of this is to decide which autocomplete field the option was selected from (extensibility)
const autoCompleteSelect = (value) => {
    if (subjects.some(subject => subject === value)) {
        getYears(value);
    }
};

//called when year is chosen
const getMaterials = (year) => {
    //update global year variable
    YEAR = year;
    document.getElementById("yearSelect").innerHTML = year;
    //fetch materials from api
    axios.get(`${url}/api/${EXAM}/${SUBJECT}/${year}`).
    then(function(response) {
        //divide results into exam papers and marking schemes
        examList = [];
        markList = [];
        response.data.forEach(material => {
            if (material.type === "exam") examList.push(material);
            else markList.push(material);
        });
        displayMaterials([examList, markList]);
    });
    
};

const filterToggle = document.createElement("button");
filterToggle.classList.add("btn");
filterToggle.classList.add("btn-danger");
filterToggle.classList.add("d-inline")
filterToggle.classList.add("filterToggle");
filterToggle.type = "button";
filterToggle.setAttribute("data-toggle", "collapse");
filterToggle.setAttribute("data-target", "#filters");
filterToggle.innerHTML = "Filter Results";

const displayMaterials = (materials) => {
        //update GUI state, to show materials
        //title is just the fields the user has selected
        resultsTitleContainer = document.getElementById("resultsTitleContainer");
        resultsTitleContainer.innerHTML = "";
        resultsTitle = document.createElement("h2");
        resultsTitle.classList.add("d-inline");
        resultsTitle.innerHTML = `${examDict[EXAM]} ${SUBJECT} ${YEAR}`;
        resultsTitleContainer.appendChild(resultsTitle);
        resultsTitleContainer.appendChild(filterToggle);
        //clear results
        const results = document.getElementById("results");
        results.innerHTML = "";
        //column for each type of material  (exam papers and marking schemes)
        materials.forEach((type) => {    
            if (type.length > 0) {
                //column header, exam papers or marking schemes
                const typeCol = document.createElement("div");
                typeCol.classList.add("col");
                typeCol.classList.add("mb-4");
                const typeHeader = document.createElement("h3");
                typeHeader.innerHTML = typeDict[type[0].type];
                typeCol.appendChild(typeHeader);
                //row for each result of this type
                type.forEach((material) => {
                    const result = document.createElement("p");
                    result.innerHTML = 
                        `<a target="_blank" class='btn btn-primary' href='${material.reslink}'>${material.resname}</a>`;
                    typeCol.appendChild(result);
                });
                results.appendChild(typeCol);
            };
        });
};

//filters materials based on language and level
const filter = (materials, lang, lvl) => {
    let newMaterials = [[], []];
    materials.forEach((type) => {
        type.forEach((result) => {
            // composite filter, if one isnt set the string is empty so the .includes returns true
            if (result.resname.includes(lvl) && result.resname.includes(lang)) {
                newMaterials[materials.indexOf(type)].push(result);
            }
        });
    });
    displayMaterials(newMaterials);
};

//calls filter function when language or level option is selected
const langButtons = document.getElementById("lang").querySelectorAll("button");
const lvlButtons = document.getElementById("lvl").querySelectorAll("button");

langButtons.forEach((button) => {
    button.onclick = () => {
        chooseFilter(langButtons, button.value);
    };
});
lvlButtons.forEach((button) => {
    button.onclick = () => {
        chooseFilter(lvlButtons, button.value);
    };
}); 

const chooseFilter = (buttonSet, value) => {
    //reset filter if button is already selected
    if ((value === LANG && buttonSet == langButtons)) {
        LANG = "";
        buttonSet.forEach((button) => {
            button.classList.remove("btn-dark");
            button.classList.add("btn-outline-dark");
        });
    }else if ((value === LVL && buttonSet == lvlButtons)) {
        LVL = "";
        buttonSet.forEach((button) => {
            button.classList.remove("btn-dark");
            button.classList.add("btn-outline-dark");
        });
    }else{
        //update global language or level variable
        if (buttonSet === langButtons) LANG = value;
        else LVL = value;

        //old button is the one that was selected before, clear that filter
        buttonSet.forEach((button) => {
        if (button.value === value) {
            button.classList.remove("btn-outline-dark");
            button.classList.add("btn-dark");
        } else {
            button.classList.remove("btn-dark");
            button.classList.add("btn-outline-dark");
        }
    });
    }
    filter([examList, markList], LANG, LVL);
};

//event listener for exam selection
["lc", "jc", "lca"].map((id)=>{
    document.getElementById(id).addEventListener("click", (e)=>{
        getSubjects(id);
    });
});
