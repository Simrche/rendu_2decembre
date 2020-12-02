// TENTATIVE DE FAIRE LE CHAT EN AJAX

// $('#msgChat').click(function(e) {
//     e.preventDefault();

//     var nouveau = $('#contentMsg');

//     $.ajax({
//         url:"../App/msgChat.php",
//         dataType:"json",
//         type : post,
//         data:'type='+nouveau,
//         success: function(reponse){
//             var nouveau = $('#contentMsg').val()
//             $('#messageChat').html('')
//             reponse.forEach(pseudo => {
//                 $('#messageChat').append(`<p><span>${pseudo.msg_pseudo}</span> : ${pseudo.msg_message}</p>`)
//             })
//         }
//     })
// })