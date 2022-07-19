document.body.addEventListener("click", function (event) {
    let elem = event.target.closest(".sort");
    // Если кликнули на элемент сортировки (по-возрастанию или по-убыванию)
    if (elem) {
        // Говорим пользователю, что выполняется загрузка (на случай задержек)
        document.querySelector('#process-message').innerText = 'Загрузка...';
        // Если текущий элемент (по которому кликнули) содержит класс ниже
        if (elem.classList.contains('bi-arrow-up')) {
            // Удаляем класс selected у сеседнего элемент (не могут быть выбраны оба направления у одного поля)
            elem.nextElementSibling.classList.remove('selected');
            // Если у текущего элемента не была сортировка по возрастанию
            if (elem.parentElement.getAttribute('data-type-sort') != 'ASC') {
                // Отмечаем, для сортировки по возрастанию
                elem.parentElement.setAttribute('data-type-sort', 'ASC');
                // Выделяем выбранный элемент
                elem.classList.add('selected');
            } else {
                //иначе (если была сортировка по возрастанию), убираем сортировку 
                elem.parentElement.setAttribute('data-type-sort', '');
                // Снимаем выделение выбранного элемента
                elem.classList.remove('selected');
            }
        }
        // Если текущий элемент (по которому кликнули) содержит класс ниже
        if (elem.classList.contains('bi-arrow-down')) {
            // Удаляем класс selected у сеседнего элемент (не могут быть выбраны оба направления у одного поля)
            elem.previousElementSibling.classList.remove('selected');
            // Если у текущего элемента не была сортировка по убыванию
            if (elem.parentElement.getAttribute('data-type-sort') != 'DESC') {
                // Отмечаем, для сортировки по убыванию
                elem.parentElement.setAttribute('data-type-sort', 'DESC');
                // Выделяем выбранный элемент
                elem.classList.add('selected');
            } else {
                //иначе (если была сортировка по убыванию), убираем сортировку 
                elem.parentElement.setAttribute('data-type-sort', '');
                // Снимаем выделение выбранного элемента
                elem.classList.remove('selected');
            }
        }
        let sort = {};
        // Все элементы (поля) для которых допустимы сортировки
        let elements = document.querySelectorAll('.sort-available');
        Array.from(elements).forEach((element, index) => {
            sort[element.getAttribute('data-field')] = element.getAttribute('data-type-sort');
        });
        //Ключ токена
        let param = yii.getCsrfParam();
        // Токен
        let token = yii.getCsrfToken();
        let requestData = {
            sort: new URLSearchParams(sort).toString() // Формируем строку в формате urlencoded
        };
        requestData[param] = token;
        // Отправляем запрос
        fetch('/index.php?r=image/sort', {
            method: 'POST',
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: new URLSearchParams(requestData).toString()
        }).then(function(response) {
            return response.text();
        }).then(function(html) {
            // Заменяем содержимое таблицы отсортированными данными
            document.querySelector('tbody').innerHTML = html;
            document.querySelector('#process-message').innerText = '';
        });
    }
  });