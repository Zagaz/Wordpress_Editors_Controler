<?php 
/*

This is the whole logic to:
- Filter all user with EDITORS role.
- Get the inputus from costumizer.php
- Outputs the results.

*/

//==== Editors Controller Shortcode
function editors_shortcode($atts, $content = null)
{
    // Checks if it's manual or auto (From costumizer.php)
    $is_Manual = get_theme_mod('Editors_setting');

    // get users by role
    $users = get_users(array(
        'role' => 'editor'
    ));

    $editors = array();

    foreach ($users as $user)
    {

        // array push
        array_push($editors, array(
            'priority' => get_theme_mod('editor_' . $user->ID . '') ,
            'ID' => $user->ID,
            'name' => get_user_meta($user->ID, 'last_name', true) ,

        ));

    }
?>
    // sort $editor array by priority else by name
    if ($is_Manual != 'auto')
    {
        usort($editors, function ($a, $b)
        {
            return $a['priority'] - $b['priority'];
        });
    }
    else
    {
        usort($editors, function ($a, $b)
        {
            return strcmp($a['name'], $b['name']);
        });

    }
	
	// Output Logic

    $output = '';

    for ($i = 0;$i < count($editors);$i++)
    {
        $id = $editors[$i]['ID'];

        if (get_field('title', 'user_' . $id))
        {
            $title = get_field('title', 'user_' . $id);

        }
        if (get_field('office', 'user_' . $id))
        {
            $office = get_field('office', 'user_' . $id);

        }
        if (get_field('department', 'user_' . $id))
        {

            $department = get_field('department', 'user_' . $id);

        }

        $output .= '<div class="editor">';
        $output .= "<img src='" . get_field('picture', 'user_' . $id) . "' class='editor-image' />";

        $output .= '<div class="editor-text"><a href="' . esc_url(get_author_posts_url($id)) . '"><span class="name">' . get_the_author_meta('display_name', $id) . '</span></a>';

        $output .= "<div class='editor-title'>" . get_field('title', 'user_' . $id) . ",&nbsp;</div>";
        $output .= "<div class='editor-branch'>" . get_field('office', 'user_' . $id) . "</div>";
        $output .= "<div class='editor-location'>" . get_field('department', 'user_' . $id) . "</div>";
        $output .= '</div>
        </div>';

    }
    return $output;
}
add_shortcode('editors', 'editors_shortcode');
