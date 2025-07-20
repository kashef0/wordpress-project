<div id="comments" class="comments-area">
    <h2 class="comments-title">Lämna en kommentar</h2>

    <?php
    comment_form([
        'title_reply' => 'Lämna en kommentar',
        'label_submit' => 'Skicka',
        'comment_notes_before' => '',
        'comment_notes_after' => '',
        'fields' => [
            'author' => '<p><label for="author">Namn</label><input id="author" name="author" type="text" required></p>',
            'email'  => '<p><label for="email">E-post</label><input id="email" name="email" type="email" required></p>',
        ],
        'comment_field' => '<p><label for="comment">Kommentar</label><textarea id="comment" name="comment" required></textarea></p>',
    ]);
    ?>
</div>
