import {ml} from './domElement.js'
const btnTambah = document.getElementById('tambah');
const btnSubmit = document.getElementById('submit')
const target = document.querySelector('#target-container')

let totalHarga = 0

function actionValidBtb(){
    const input = document.querySelectorAll('input:required')
    if(input.length > 0){
        for(let i = 0; i < input.length; i++){
            // console.log(input[i]);
            if(input[i].value == '' || input[i].value == ''){
                btnSubmit.disabled = true
                btnSubmit.style.cursor = 'no-drop'
                btnSubmit.style.opacity = .8
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


btnTambah.addEventListener('click', () => {
    let container = ml('div', {class: 'container-detail-paket'}, [
        ml('p', {}, 'Nama Vendor'),
        ml('input', {class: 'box-input', type: 'text', name: 'nama[]'}, ),
        ml('p', {}, 'Kota Vendor'),
        ml('input', {class: 'box-input', type: 'text', name: 'kota[]'}, ),
        ml('p', {}, 'Harga Vendor'),
        ml('input', {class: 'box-input', type: 'number', name: 'harga[]'}, ),
        ml('button', {class: 'btnDelete', type: 'button'}, 'hapus')
    ])
    target.append(container)

    // set required
    // for(let i = 0; i < target.childElementCount; i++){
    //     target.children[i].children[1].required = true
    //     target.children[i].children[3].required = true
    //     target.children[i].children[5].required = true
    // }

})

function btnDeleteAction(){
    const btnDelete = document.querySelectorAll('.btnDelete')
    btnDelete.forEach(element => {
        element.addEventListener('click', () => {
            element.parentElement.remove()
        })
    });
}

// check inputan yang required
setInterval(() => {
    // actionValidBtb()
    btnDeleteAction()
}, 500)

btnSubmit.addEventListener('click', () => {
    // if(target.childElementCount == 0){
    //     console.log('kosong');
    // }
})