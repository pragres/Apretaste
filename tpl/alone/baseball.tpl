{= *AnswerSubject: $title =}
{$h1}{$title}{$_h1}
?$news
    [$news]
        <table>
            <tr>
                <td>
                   <h2>{$title}</h2>
                    <span style="font-size: 10px; color: blue;">{$date}</span>
                    <p>{$content}</p>
                </td>
            </tr>
        </table>
    [/$news]
$news?