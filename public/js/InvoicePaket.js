import { ml } from "./domElement.js";
const btnTambahBiayaLainnya = document.getElementById('tambah-biaya-lainnya')
const btnSubmit = document.getElementById('submit')
const btnCancel = document.getElementById('cancel')
const targetBiayaLainnya = document.querySelector('.multy-input-biaya-lainnya')

btnCancel.addEventListener('click', () => {
    document.getElementsByName('harga[]').forEach((e) => {
        console.log(e.value);
    })
})


// Tambah Function
btnTambahBiayaLainnya.addEventListener('click', () => {
    let container = ml('div', {class: 'form-input'}, [
        ml('input', {type: 'text', class: 'box-input', placeholder: 'keterangan', name: 'keterangan[]'}, ),
        ml('input', {type: 'number', class: 'box-input', placeholder: 'harga', name: 'harga[]'}, ),
    ])

    const btnDelete = document.createElement('button')
    btnDelete.setAttribute('type', 'button')
    btnDelete.setAttribute('class', 'btnDelete')
    btnDelete.innerHTML = 'hapus'
    btnDelete.addEventListener('click', () => {
        btnDelete.parentElement.remove()
    })

    container.append(btnDelete)
    targetBiayaLainnya.append(container)

    for(let i = 0; i < targetBiayaLainnya.childElementCount; i++){
        targetBiayaLainnya.children[i].children[0].required = true
        targetBiayaLainnya.children[i].children[1].required = true
    }
})

// Submit Action
function actionValidBtb(){
    const input = document.querySelectorAll('input:required')
    if(input.length > 0){
        for(let i = 0; i < input.length; i++){
            // console.log(input[i]);
            if(input[i].value == '' || input[i].value == ''){
                btnSubmit.disabled = true
                btnSubmit.style.cursor = 'no-drop'
                btnSubmit.style.opacity = .5
                break
            }else{
                btnSubmit.disabled = false
                btnSubmit.removeAttribute('style')
            }
        }
    }else{
        btnSubmit.disabled = false
        btnSubmit.removeAttribute('style')
    }
}


setInterval(() => {
    // refresh .5s
    actionValidBtb()
}, 500);