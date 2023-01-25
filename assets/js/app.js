/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
//import './styles/app.css';

import '../css/app.scss';

import {Dropdown} from "bootstrap";

document.addEventListener('DOMContentLoaded', () => {
   // enableDropdowns();

   new App();
});

class App {
    constructor() {
        this.enableDropdowns();
        this.handleCommentForm();
    }
    
    enableDropdowns() {
        const  dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
        dropdownElementList.map(function (dropdownToggleEl) {
            return new Dropdown(dropdownToggleEl)
        });
    }

    handleCommentForm() {
        const commentForm = document.querySelector('form.comment-form');
        //console.log(commentForm);

        if (null === commentForm){
            return;
        }

        commentForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const response = await fetch('/ajax/comments', {
                method: 'POST', 
                body: new FormData(e.target)

            });

            if(!response.ok) {
                return;
            }

            const json = await response.json();

           // console.log(json);
            
           if ( json.code === 'COMMENT_ADD_SUCCESSFULLY'){
            const commentList    = document.querySelector('.comment-list');
            const commentCount   = document.querySelector('.comment-count');
            const commentContent = document.querySelector('#comment_content');console.log(commentContent);
            commentList.insertAdjacentHTML('beforeend', json.message);
            commentList.lastElementChild.scrollIntoView();
            commentCount.innerText = json.numberOfComments;
            commentContent.value = '';

           }

        });
        
    }
    
}