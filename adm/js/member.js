let defaultExp = Date.now() + 30*24*60*60*1000;
document.getElementById('memberExp').value = new Date(defaultExp).toISOString().split('T')[0];

const jsonForm = new FormData()

function importJson(){
    jsonForm.append('json',document.getElementById('json-upload').files[0])
    fetch('/ypc%20server/adm/actions/json-upload.php',{
        method: "POST",
        body: jsonForm
    }).then(
        res=>res.json()
    ).then(
        res=>{
            if(res.status=="success"){
                alert(res.message)
            }else{
                alert(res.message)
            }
        }
    ).catch(
        err=> {alert(err)}
    )
}

function bulkDelete(){
    fetch("/ypc%20server/adm/actions/bulk-del-members.php",{
        method: "POST"
    }).then(
        res=>res.json()
    ).then(
        res=>{
            if(res.status==="success"){
                alert(res.message)
            }else{
                alert(res.message)
            }
        }
    ).catch(
        err=> alert(err)
    )
}


function submit(){
    const id = document.getElementById('memberId').value;
    const exp = document.getElementById('memberExp').value;
    if(id){
        fetch('/ypc%20server/actions/add-member.php?'+ new URLSearchParams({id:id, exp:exp}).toString(),{
            method:'GET'
        }).then(
            res => res.json()
        ).then(
            res =>{
                if(res['status'] === 'success'){
                    alert('Added member successfully!')
                    window.location.reload();
                }else{
                    alert('Add member failed: '+res['message']);
                }
            }
        )
    }
}

function removeMember(e){
    const id = e.getAttribute('memberId');
    if(id){
        fetch('/ypc%20server/actions/remove-member.php?'+ new URLSearchParams({id:id}).toString(),{
            method:'GET'
        }).then(
            res => res.json()
        ).then(
            res =>{
                if(res['status'] === 'success'){
                    alert('Removed member successfully!')
                    window.location.reload();
                }else{
                    alert('Remove member failed: '+res['message']);
                }
            }
        )
    }
}

function updateMember(e){
    const id = e.getAttribute('memberId');
    const exp = document.getElementById('exp_'+id).value;
    console.log(id, exp)
    if(id && exp){
        fetch('/ypc%20server/actions/update-exp.php?'+ new URLSearchParams({id:id, exp:exp}).toString(),{
            method:'GET'
        }).then(
            res => res.json()
        ).then(
            res =>{
                if(res['status'] === 'success'){
                    alert('Updated member successfully!')
                    window.location.reload();
                }else{
                    alert('Update member failed: '+res['message']);
                }
            }
        )
    }
}   