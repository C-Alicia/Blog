let textcomment = document.querySelector('#comments')
let button = document.querySelector('#button')
let postId = textcomment.getAttribute('data-id')
let listcomments = document.querySelector('#listcomment')

//DATA-id fait partie de textarea - //

button.addEventListener('click', commentaires)

function commentaires() {
  fetch('/create/' + postId, {
    method: 'POST',
    Headers: { 'Content-Type': 'Application/json' },
    body: JSON.stringify({ contentvalue: textcomment.value }),
  })
    .then(function (response) {
      return response.json()
    })
    .then(function (data) {
      listcomments.innerHTML = ''

      for (comment of data) {
        /*         console.log(data) */

        listcomments.innerHTML +=
          '<div class="card alert alert-dark"><div class="comments"><p class="user">' +
          comment.autorname +
          '</p><div class="content">' +
          comment.content +
          '</div><span class="date">publiée le ' +
          comment.createdAt +
          '</span></div></div>'
      }
    })
}

