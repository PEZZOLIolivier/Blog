
import './styles/app.css';

import './bootstrap';

const $ = require('jquery');
$(document).ready(() => {
    $("#btn-post-comment").on('click', function(e) {
        e.preventDefault();
        let commentMesg = $("#comment-input").val();
        let currentUrl = document.URL;
        let listTokenUrl = currentUrl.split('/')
        let articleId = listTokenUrl.slice(-1).pop()

        $.ajax({
            url: "/article/" + articleId + "/comment/new",
            method: "POST",
            contentType: "application/json; charset=utf-8",
            dataType: 'json',
            data: JSON.stringify({
                "comment": commentMesg
            }),
            success: function(res) {
                let body = res['body'];
                let author = res['author'];
                let created = res['created'];
                let commentHtml = `
                <div class="comment flex justify-start mb-5 rounded-3">
                    <div>
                        <div class="d-block p-1 rounded-lg shadow-sm bg-light">
                            <div>
                                <p><b>${created} - ${author} à dit:</b></p>
                                <p>${body}</p>
                            </div>
                        </div>
                    </div>
                 </div>
                `
                $("#list-comments").prepend(commentHtml);
                $("#comment-input").val("");
            }
        });
    })
})
