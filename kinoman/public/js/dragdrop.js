'use strict';

const profile = document.querySelector('.position_container');
const collections = document.querySelector('.user_collections');

const collectionListElement = document.querySelectorAll(`.main_catalog_section`);
const collectionElements = [];

for (const list of collectionListElement) {
    let newlist = list.querySelectorAll('.main_catalog_link')
    collectionElements.push(newlist)
}

for (const list of collectionElements) {
    list.forEach(el => el.draggable = true)
}

collectionListElement.forEach((el) => {
    el.addEventListener(`dragstart`, (evt) => {
        evt.target.classList.add(`selected`);
    })

    el.addEventListener(`dragend`, (evt) => {
        evt.target.classList.remove(`selected`);
    });
})

const getNextElement = (cursorPosition, currentElement) => {
    const currentElementCoord = currentElement.getBoundingClientRect();
    const currentElementCenter = currentElementCoord.y + currentElementCoord.height / 2;

    const nextElement = (cursorPosition < currentElementCenter) ?
        currentElement :
        currentElement.nextElementSibling;

    return nextElement;
};

collectionListElement.forEach((el) => {
    el.addEventListener(`dragover`, (evt) => {
        evt.preventDefault();

        const activeElement = document.querySelector(`.selected`);
        const currentElementChildren = evt.target;

        let currentElement = currentElementChildren.parentElement
        let parentBlock = currentElement.parentElement

        if (currentElement.classList.contains('main_catalog')) {
            let newParentBlock = currentElement.querySelector('.main_catalog_section')
            newParentBlock.prepend(activeElement)
        } else if (currentElement.classList.contains(`main_catalog_link`)) {

            const isMoveable = activeElement !== currentElement &&
                currentElement.classList.contains(`main_catalog_link`);

            if (!isMoveable) {
                return;
            }

            const nextElement = getNextElement(evt.clientY, currentElement);

            parentBlock.insertBefore(activeElement, nextElement);
        }

    });
});

function addClass() {
    profile.classList.add('fixed-position');
    collections.classList.add('collections_margin')

    setNewWidth()
}

function removeClass() {
    profile.classList.remove('fixed-position');
    collections.classList.remove('collections_margin')
    profile.removeAttribute('style')
}

function findwidthCollectionsBlock() {
    let width = collections.clientWidth
    return width
}

function setNewWidth() {
    let newWidth = findwidthCollectionsBlock() + 2;
    let strWidth = String(newWidth);
    profile.style.width = strWidth + 'px';
}

window.addEventListener('scroll', (e) => {
    let positionY = window.scrollY


    if (positionY > 115) {
        let colWidth = String(collections.clientWidth + 2) + 'px'

        if (profile.style.width != colWidth) {
            setNewWidth()
        }
        if (profile.classList.contains('fixed-position')) {
            return
        } else {
            addClass()
        }

    } else if (positionY < 115) {
        if (profile.classList.contains('fixed-position')) {
            removeClass()
        } else {
            return
        }
    }
})