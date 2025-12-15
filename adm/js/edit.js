var vipIndex;

const imgForm = new FormData();
let isRecommended = false;


function uploadImg(){
    imgForm.append('img',document.getElementById('img-upload').files[0]);
    fetch('/ypc%20server/adm/actions/img-upload.php',{
        method: 'POST',
        body: imgForm
    }).then(
        res => res.json()
    ).then(
        res=>{
            if(res['status']==='success'){
                comic.poster = res['url'];
                document.getElementById('poster').value = res['url'];
                alert('Image uploaded successfully!');
            }else{
                alert('Image upload failed: '+res['message']);
            }
        }
    )
}

function submit(data){
    let finalApi=[];
    document.querySelectorAll('.api-input').forEach((input,i)=>{
        console.log(i)
        finalApi[i] = input.value;
    })
    data['api'] = finalApi;
    data['recommend'] = isRecommended;
    if(data['id']){
        fetch('/ypc%20server/adm/actions/edit-post.php',{
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data),
            method: 'POST'
        }).then(
            res => res.json()
        ).then(
            res => {
                if(res['status'] === 'success'){
                    alert('Edit successful!')
                }else{
                    alert('Edit failed: '+res['message']);
                }
            }
        ).catch(
            err => {
                alert('Edit failed: '+err);
            }
        );
    }else{
        alert('ID is required for editing.');
    }
}

function addApi(){
    let inputGp = document.querySelectorAll('.api-input-group') || []
    const wrapper = document.getElementById('api-wrapper');
    const currentId = inputGp.length > 0 ?  Number(inputGp[inputGp.length-1].getAttribute('index'))+1 : 0
    comic['api'][currentId] = null;
    console.log(comic)
    console.log(currentId)
    const inputChild = document.createElement('div')
    inputChild.setAttribute('class','mb-3 api-input-group input-group')
    inputChild.setAttribute('index',currentId)
    inputChild.setAttribute('id','api_'+currentId)
    inputChild.innerHTML = "<input onchange='onChangeApi("+currentId+",this)' type='text' class='form-control api-input' ><button onclick='removeApi("+currentId+")' type='button' class='btn btn-danger'>remove</button>"
    wrapper.appendChild(inputChild)
}

function removeApi(index){
    comic['api'].splice(index,1);
    document.getElementById(`api_${index}`).remove()
    if((vipIndex==index)){
        vipIndex = null;
    }
}

function ifVipApi(index){
    if(comic['api'][index].toLowerCase().includes('vip')){
        vipIndex = index;
        console.log(vipIndex)
        return true
    }
    return false
}

function onChangeApi(index,e){
    comic.api[index] = e.value
    ifVipApi(index)
    if((vipIndex==index) && (ifVipApi(index)==false)){
        vipIndex = null
    }
}

document.getElementById('submit').addEventListener('click',function(e){
    e.preventDefault();
    submit(comic);
});

document.getElementById('rc-check').addEventListener('change',function(e){
    e.preventDefault();
    isRecommended = e.target.checked;
});