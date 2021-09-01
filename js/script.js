// $(document).ready(function () {
//     $('.icon-menu').click(function (event) {
//         $('.icon-menu,.menu__body').toggleClass('active');
//     });

//     // Спойлеры
//     $('.section-filter__title').click(function (event) {
//         event.target.classList.toggle('active');
//     });

//     $(document).on('click', '.section-filter__checkbox', function (event) {
//         if ($(this).hasClass('_active')) {
//             $(this).find('input').prop('checked', false);
//         } else {
//             $(this).find('input').prop('checked', true);
//         }
//         $(this).toggleClass('_active');
//         return false;
//     });
// });


// let menuPageBurger = document.querySelector('.menu-page__burger');
// let menuPageBody = document.querySelector('.menu-page__body');
// menuPageBurger.addEventListener("click", function (e) {
//     menuPageBurger.classList.toggle('active');
//     $(".menu-page__body").slideToggle("slow"); // my
//     menuPageBody.classList.toggle('active');
// });

// let searchSelect = document.querySelector('.search-page__title');
// let categoriesSearch = document.querySelector('.categories-search')
// searchSelect.addEventListener("click", function (e) {
//     searchSelect.classList.toggle('active');
//     $(".categories-search").slideToggle("slow"); // my
// });


// let checkboxCategories = document.querySelectorAll('.categories-search__checkbox');
// for (let index = 0; index < checkboxCategories.length; index++) {
//     const checkboxCategory = checkboxCategories[index];
//     checkboxCategory.addEventListener("change", function (e) {
//         checkboxCategory.classList.toggle('active');
//         let checkboxActiveCategories = document.querySelectorAll('.categories-search__checkbox.active')
//         if (checkboxActiveCategories.length > 0) {
//             searchSelect.classList.add('categories');
//             let searchQuantity = searchSelect.querySelector('.search-page__quantity');
//             searchQuantity.innerHTML = searchQuantity.getAttribute('data-text') + ' ' + checkboxActiveCategories.length;
//         } else {
//             searchSelect.classList.remove('categories');
//         }
//     });
// }


// let menuParents = document.querySelectorAll('.menu-page__parent');
// for (let index = 0; index < menuParents.length; index++) {
//     const menuParent = menuParents[index];
//     menuParent.addEventListener("mouseenter", function (e) {
//         menuParent.classList.add('active');
//     });
//     menuParent.addEventListener("mouseleave", function (e) {
//         menuParent.classList.remove('active');
//     });
// }


// $('a[href^="#"]').on('click', function (event) {
//     // отменяем стандартное действие
//     event.preventDefault();

//     var sc = $(this).attr("href"),
//         dn = $(sc).offset().top;
//     /*
//     * sc - в переменную заносим информацию о том, к какому блоку надо перейти
//     * dn - определяем положение блока на странице
//     */

//     $('html, body').animate({ scrollTop: dn }, 1000);

//     /*
//     * 1000 скорость перехода в миллисекундах
//     */
// });


// (function () {
//     let originalPositions = [];
//     let daElements = document.querySelectorAll('[data-da]');
//     let daElementsArray = [];
//     let daMatchMedia = [];
//     //Заполняем массивы
//     if (daElements.length > 0) {
//         let number = 0;
//         for (let index = 0; index < daElements.length; index++) {
//             const daElement = daElements[index];
//             const daMove = daElement.getAttribute('data-da');
//             if (daMove != '') {
//                 const daArray = daMove.split(',');
//                 const daPlace = daArray[1] ? daArray[1].trim() : 'last';
//                 const daBreakpoint = daArray[2] ? daArray[2].trim() : '767';
//                 const daType = daArray[3] === 'min' ? daArray[3].trim() : 'max';
//                 const daDestination = document.querySelector('.' + daArray[0].trim())
//                 if (daArray.length > 0 && daDestination) {
//                     daElement.setAttribute('data-da-index', number);
//                     //Заполняем массив первоначальных позиций
//                     originalPositions[number] = {
//                         "parent": daElement.parentNode,
//                         "index": indexInParent(daElement)
//                     };
//                     //Заполняем массив элементов 
//                     daElementsArray[number] = {
//                         "element": daElement,
//                         "destination": document.querySelector('.' + daArray[0].trim()),
//                         "place": daPlace,
//                         "breakpoint": daBreakpoint,
//                         "type": daType
//                     }
//                     number++;
//                 }
//             }
//         }
//         dynamicAdaptSort(daElementsArray);

//         //Создаем события в точке брейкпоинта
//         for (let index = 0; index < daElementsArray.length; index++) {
//             const el = daElementsArray[index];
//             const daBreakpoint = el.breakpoint;
//             const daType = el.type;

//             daMatchMedia.push(window.matchMedia("(" + daType + "-width: " + daBreakpoint + "px)"));
//             daMatchMedia[index].addListener(dynamicAdapt);
//         }
//     }
//     //Основная функция
//     function dynamicAdapt(e) {
//         for (let index = 0; index < daElementsArray.length; index++) {
//             const el = daElementsArray[index];
//             const daElement = el.element;
//             const daDestination = el.destination;
//             const daPlace = el.place;
//             const daBreakpoint = el.breakpoint;
//             const daClassname = "_dynamic_adapt_" + daBreakpoint;

//             if (daMatchMedia[index].matches) {
//                 //Перебрасываем элементы
//                 if (!daElement.classList.contains(daClassname)) {
//                     let actualIndex = indexOfElements(daDestination)[daPlace];
//                     if (daPlace === 'first') {
//                         actualIndex = indexOfElements(daDestination)[0];
//                     } else if (daPlace === 'last') {
//                         actualIndex = indexOfElements(daDestination)[indexOfElements(daDestination).length];
//                     }
//                     daDestination.insertBefore(daElement, daDestination.children[actualIndex]);
//                     daElement.classList.add(daClassname);
//                 }
//             } else {
//                 //Возвращаем на место
//                 if (daElement.classList.contains(daClassname)) {
//                     dynamicAdaptBack(daElement);
//                     daElement.classList.remove(daClassname);
//                 }
//             }
//         }
//         customAdapt();
//     }

//     //Вызов основной функции
//     dynamicAdapt();

//     //Функция возврата на место
//     function dynamicAdaptBack(el) {
//         const daIndex = el.getAttribute('data-da-index');
//         const originalPlace = originalPositions[daIndex];
//         const parentPlace = originalPlace['parent'];
//         const indexPlace = originalPlace['index'];
//         const actualIndex = indexOfElements(parentPlace, true)[indexPlace];
//         parentPlace.insertBefore(el, parentPlace.children[actualIndex]);
//     }
//     //Функция получения индекса внутри родителя
//     function indexInParent(el) {
//         var children = Array.prototype.slice.call(el.parentNode.children);
//         return children.indexOf(el);
//     }
//     //Функция получения массива индексов элементов внутри родителя 
//     function indexOfElements(parent, back) {
//         const children = parent.children;
//         const childrenArray = [];
//         for (let i = 0; i < children.length; i++) {
//             const childrenElement = children[i];
//             if (back) {
//                 childrenArray.push(i);
//             } else {
//                 //Исключая перенесенный элемент
//                 if (childrenElement.getAttribute('data-da') == null) {
//                     childrenArray.push(i);
//                 }
//             }
//         }
//         return childrenArray;
//     }
//     //Сортировка объекта
//     function dynamicAdaptSort(arr) {
//         arr.sort(function (a, b) {
//             if (a.breakpoint > b.breakpoint) { return -1 } else { return 1 }
//         });
//         arr.sort(function (a, b) {
//             if (a.place > b.place) { return 1 } else { return -1 }
//         });
//     }
//     //Дополнительные сценарии адаптации
//     function customAdapt() {
//         //const viewport_width = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
//     }
// }());


// -------------------- select ------------------------
$('.select').each(function () {
    const _this = $(this),
        selectOption = _this.find('option'),
        selectOptionLength = selectOption.length,
        selectedOption = selectOption.filter(':selected'),
        duration = 350; // длительность анимации 
    _this.hide();
    _this.wrap('<div class="select"></div>');
    $('<div>', {
        class: 'new-select',
        text: _this.children('option:disabled').text()
    }).insertAfter(_this);
    const selectHead = _this.next('.new-select');
    $('<div>', {
        class: 'new-select__list'
    }).insertAfter(selectHead);
    const selectList = selectHead.next('.new-select__list');
    for (let i = 1; i < selectOptionLength; i++) {
        $('<div>', {
            class: 'new-select__item',
            html: $('<span>', {
                text: selectOption.eq(i).text()
            })
        })
            .attr('data-value', selectOption.eq(i).val())
            .appendTo(selectList);
    }
    const selectItem = selectList.find('.new-select__item');
    selectList.slideUp(0);
    selectHead.on('click', function () {
        if (!$(this).hasClass('on')) {
            $(this).addClass('on');
            selectList.slideDown(duration);
            selectItem.on('click', function () {
                let chooseItem = $(this).data('value');
                $('select').val(chooseItem).attr('selected', 'selected');
                selectHead.text($(this).find('span').text());
                selectList.slideUp(duration);
                selectHead.removeClass('on');
            });
        } else {
            $(this).removeClass('on');
            selectList.slideUp(duration);
        }
    });
});

// // -------------------- show ------------------------
// $('.show').each(function () {
//     const _this = $(this),
//         selectOption = _this.find('option'),
//         selectOptionLength = selectOption.length,
//         selectedOption = selectOption.filter(':selected'),
//         duration = 450; // длительность анимации 
//     _this.hide();
//     _this.wrap('<div class="select show"></div>');
//     $('<div>', {
//         class: 'new-select new-show',
//         text: _this.children('option:disabled').text()
//     }).insertAfter(_this);
//     const selectHead = _this.next('.new-select');
//     $('<div>', {
//         class: 'new-select__list new-show__list'
//     }).insertAfter(selectHead);
//     const selectList = selectHead.next('.new-select__list');
//     for (let i = 1; i < selectOptionLength; i++) {
//         $('<div>', {
//             class: 'new-select__item new-show__item',
//             html: $('<span>', {
//                 text: selectOption.eq(i).text()
//             })
//         })
//             .attr('data-value', selectOption.eq(i).val())
//             .appendTo(selectList);
//     }
//     const selectItem = selectList.find('.new-select__item');
//     selectList.slideUp(0);
//     selectHead.on('click', function () {
//         if (!$(this).hasClass('on')) {
//             $(this).addClass('on');
//             selectList.slideDown(duration);
//             selectItem.on('click', function () {
//                 let chooseItem = $(this).data('value');
//                 $('select').val(chooseItem).attr('selected', 'selected');
//                 selectHead.text($(this).find('span').text());
//                 selectList.slideUp(duration);
//                 selectHead.removeClass('on');
//             });
//         } else {
//             $(this).removeClass('on');
//             selectList.slideUp(duration);
//         }
//     });
// });

// // -------------------------- quantity(количество) ------------------------------
// let quantityButtons = document.querySelectorAll('.quantity__button');
// if (quantityButtons.length > 0) {
//     for (let index = 0; index < quantityButtons.length; index++) {
//         const quantityButton = quantityButtons[index];
//         quantityButton.addEventListener("click", function (e) {
//             let value = parseInt(quantityButton.closest('.quantity').querySelector('input').value);
//             if (quantityButton.classList.contains('quantity__button_plus')) {
//                 value++;
//             } else {
//                 value = value - 1;
//                 if (value < 1) {
//                     value = 1
//                 }
//             }
//             quantityButton.closest('.quantity').querySelector('input').value = value;
//         });
//     }
// }

// // -------------------------- (табы) ------------------------------
// var jsTriggers = document.querySelectorAll('._tabs-item'),
//     jsContents = document.querySelectorAll('._tabs-block');
// jsTriggers.forEach(function (trigger) {
//     trigger.addEventListener('click', function () {
//         var id = this.getAttribute('data-tab'),
//             content = document.querySelector('._tabs-block[data-tab="' + id + '"]'),
//             activeTrigger = document.querySelector('._tabs-item._active'),
//             activeContent = document.querySelector('._tabs-block._active');

//         activeTrigger.classList.remove('_active'); // 1
//         trigger.classList.add('_active'); // 2

//         activeContent.classList.remove('_active'); // 3
//         content.classList.add('_active'); // 4
//     });
// });