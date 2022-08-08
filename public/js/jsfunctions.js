const fak = document.getElementById('fakultas');
const jur = document.getElementById('jurusan');

fak.addEventListener('change', function(){
    let ajax = new XMLHttpRequest();
    console.log(fak.value);

    ajax.onreadystatechange = function(){
        if(ajax.readyState==4 && ajax.status==200){
            jur.innerHTML = ajax.response;
        }
    }

    ajax.open('POST', 'include/ajax/getJurusan.php?id=' + fak.value, true);
    ajax.send();
});

const srcField = document.getElementById('fieldSearch');
const tbl = document.getElementById('tableData');

srcField.addEventListener('keyup', function () {
    let ajax = new XMLHttpRequest();
    console.log(srcField.value);

    ajax.onreadystatechange = function(){
        if(ajax.readyState==4 && ajax.status==200){
            tbl.innerHTML = ajax.response;
        }
    }

    ajax.open('POST', 'include/ajax/getRegist.php?id=' + srcField.value, true);
    ajax.send();
});

