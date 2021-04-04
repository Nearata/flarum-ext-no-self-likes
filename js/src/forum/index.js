import { extend } from 'flarum/common/extend';
import CommentPost from 'flarum/forum/components/CommentPost';

app.initializers.add('nearata-no-self-likes', app => {
    extend(CommentPost.prototype, 'actionItems', function (items) {
        const postUserId = Number(this.attrs.post.user().id());
        const sessionUserId = Number(app.session.user.id());

        if (postUserId === sessionUserId) {
            items.remove('like');
        }
    });
});
