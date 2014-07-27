{= *AnswerSubject: Buzones de {$apretaste} =}
<p align="justify" style="{$font}">
La siguiente es la lista de buzones de correo electr&oacute;nico
a los cuales puede escribir para interactuar con {$apretaste}.
</p>

{= addresses: [
    "anuncios@apretaste.com",
    "apretaste@gmail.com",
    "apretaste@mail.com",
    "apretaste@email.com",
    "apretaste@post.com",
    "apretaste@outlook.com",
    "apretaste@hotmail.com",
    "apretaste@live.com",
    "apretaste@rebateninja.com",
    "apretaste@pragres.com"    
] =}
<ul style="{$font}">
[$addresses]
    <li><a href="mailto:{$value}?subject=ayuda">{$value}</a></li>
[/$addresses]
</ul>