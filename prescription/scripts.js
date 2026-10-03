async function load_prescription(){
    try{
        const response = await fetch('get_prescription.php');
        const data= await response.json();

        display_status('active-prescription-container',data.active);
        display_status('upcoming-prescription-container',data.upcoming);
        display_status('completed-prescription-container',data.completed);
    }
    catch(error){
        console.error('Error Loding presctipton ; ',error);
    }
}

function display_status(containerID,data){
    const container=document.getElementById(containerID);
    if (!container) {
        console.error(`Container ID '${containerID}' not found in HTML.`);
        return;
    }
    container.innerHTML='';

    if(!data || data.length===0){
        container.innerHTML='<p>No prescripton Found</p>';
        return;
    }

    data.forEach(item=>{
        const card=document.createElement('div');
        card.className='pescription-card';
        card.innerHTML=
        `<div class="content">
            <div class="heading">
                <p class="med_name">${item.medicine_name}</p>
                <p class="date">${item.date_time}</p>
            </div>
            <div class="details">
                <div class="dosage"><p class="h">Dosage : </p><P>${item.dosage}</P></div>
                <div class="quantity"><p class="h">Quantity : </p><P>${item.quantity}</P></div>
                <div class="status"><p class="h">Status : </p><P>${item.status}</P></div>
            </div>
        </div>`
;

        container.appendChild(card);
    });
}

async function search_opp(searchKeyWord){
 try{
     const response=await fetch('get_prescription.php');
     const data=await response.json();
     
     const prescriptionStatus=['active','upcoming','completed']
     for(const eachstatus of prescriptionStatus){
        const serachresult=[];
        const items=data[eachstatus] || [];
        items.forEach(item=>{
            if(item.medicine_name.toLowerCase().includes(searchKeyWord.trim().toLowerCase())){
                serachresult.push(item);
            }
        })
        display_status(`${eachstatus}-prescription-container`,serachresult);
    }
 }
 catch(error){
    console.error('Search Operation crashed : ',error);
 }
}

load_prescription();

/*Reload section*/
const reload=document.getElementById('reload');
reload.addEventListener('click',load_prescription);


/*Search selction*/
const searchBtn=document.getElementById('submit');
searchBtn.addEventListener('click',async (e) =>{
    e.preventDefault();
    const searchKeyWord=document.getElementById('search').value;
    if(searchKeyWord){
        search_opp(searchKeyWord);
    }
    else{
        load_prescription();
    }
})
