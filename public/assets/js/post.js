/**
 * Author: Lucas de Oliveira <contato@deoliveiralucas.net>
 * Website: http://deoliveiralucas.net
 */

 !function ($) {
  'use strict';

  var Post = function () {
    this.$postBox         = $('.post-box').remove().clone(),
    this.$listPosts       = $('.list-posts'),
    this.$noPosts         = $('.no-posts'),
    this.$boxListComments = $('.list-comments'),
    this.$boxComment      = $('.box-comment').remove().clone();
  };

  Post.prototype.create = function () {
    var $this = this;

    $(document).ready(function () {
      var sendPost = $('#send-post');

      sendPost.on('click', function () {
        sendPost.attr('disabled', 'disabled');

        var title = $('#title'),
          body = $('#body');

        $.ajax({
          type: 'POST',
          url: '/api/post',
          data: {
            title: title.val(),
            body: body.val(),
            author: 'DoctrineODM'
          },
          success: function (res) {
            sendPost.removeAttr('disabled');
            title.val(''),
            body.val('');
            window.location = '/';
          },
          error: function (err) {
            sendPost.removeAttr('disabled');
            alert("Something wrong it's not correct :P");
            console.log(err);
          }
        });
      });
    });
  };

  Post.prototype.loadAll = function () {
    var $this = this;

    $(document).ready(function () {
      $.ajax({
        type: 'GET',
        url: '/api/post',
        success: function (res) {
          if (res.length > 0) {
            $this.$noPosts.hide();
          }

          res.forEach(mountPosts);

          function mountPosts(value) {
            var newPost = $this.$postBox;
            var linkPost = '/post/' + value.id;

            newPost.find('.post-title').text(value.title);
            newPost.find('.post-title').attr('href', linkPost);
            newPost.find('.post-text').text(value.body.toString().substr(0, 300));
            newPost.find('.post-author').text(value.author);
            newPost.find('.post-date').text(value.createdAt.date);
            newPost.find('.link-read-more').attr('href', linkPost);

            $this.$listPosts.append(newPost.html());
          }
        },
        error: function (err) {
          console.log(err);
        }
      })
    });
  };

  Post.prototype.loadOne = function (id) {
    var $this = this;

    $(document).ready(function () {
      $.ajax({
        type: 'GET',
        url: '/api/post/' + id,
        success: function (res) {
          $('.post-title').text(res.title);
          $('.post-author').text(res.author);
          $('.post-date').text(res.createdAt.date);
          $('.post-body').html(res.body.replace(/\n/g, "<br>"));

          $this.$boxListComments.html('');
          res.comments.forEach(function (value) {
            var newComment = $this.$boxComment;

            newComment.find('.comment-user').text(value.username);
            newComment.find('.comment-date').text(value.createdAt.date);
            newComment.find('.comment-text').html(value.comment.replace(/\n\n/g, "<br>"));

            $this.$boxListComments.append(newComment.html());
          });
        },
        error: function (err) {
          console.log(err);
        }
      });
    });
  };

  Post.prototype.addComment = function (idPost) {
    var $this = this;
    $this.$sendComment = $('.send-comment');

    $(document).ready(function () {
      $this.$sendComment.on('click', function () {
        $this.$sendComment.attr('disabled', 'disabled').text('Sending');

        var inputComment = $('.input-comment'),
          username = 'DoctrineODM';

        $.ajax({
          type: 'POST',
          url: '/api/post/' + idPost + '/comment',
          data: {
            comment: inputComment.val(),
            username: username
          },
          success: function (res) {
            $this.$sendComment.removeAttr('disabled').text('Send');
            inputComment.val('');
            $.Post.loadOne(idPost);
          },
          error: function (err) {
            $this.$sendComment.removeAttr('disabled').text('Send');
            alert("Something wrong it's not correct :P");
            console.log(err);
          }
        });
      });
    });
  };

  $.Post = new Post,
  $.Post.Constructor = Post;
}(window.jQuery);