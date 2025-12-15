const epModalEl = document.getElementById('ep-modal');
const epModal = new bootstrap.Modal(epModalEl);
let currentIndex;





function btnCheck(index){
    if(index==episodes.length-1){
        document.getElementById('prev-btn').style.display = "none"
    }else{
        document.getElementById('prev-btn').style.display = "block"
    }
    if(index==0){
        document.getElementById('next-btn').style.display = "none"
    }else{
        document.getElementById('next-btn').style.display = "block"
        
    }
}

function showIframe(epBtn){
    let link = epBtn.getAttribute('uri');
    console.log(link)
    let title = epBtn.innerText;
    let index = Number(epBtn.getAttribute('index'))
    currentIndex = index
    btnCheck(index)
    document.querySelector('.modal-title').innerText = title.toUpperCase();
    document.querySelector('#iframe').contentWindow.location.replace(link+"?hideall=1")
    epModal.show();
}

document.getElementById('next-btn').addEventListener('click',function(){
            currentIndex -=1
            document.querySelector('#iframe').contentWindow.location.replace(episodes[currentIndex]['link']+"?hideall=1")
            document.querySelector('.modal-title').innerText = episodes[currentIndex]['title']
            btnCheck(currentIndex)
        })

document.getElementById('prev-btn').addEventListener('click',function(){
            currentIndex +=1
            document.querySelector('#iframe').contentWindow.location.replace(episodes[currentIndex]['link']+"?hideall=1")
            document.querySelector('.modal-title').innerText = episodes[currentIndex]['title']
            btnCheck(currentIndex)
        })

function onCloseIframe(){
    document.querySelector('#iframe').contentWindow.location.replace("about:blank")
}