# VerifyCode（验证码）
用js+php和纯php的方式实现验证码功能
------------------------------------------
为什么要用两种方式实现验证码？

从安全的角度来说，有相当一部分的网站是用php在后台生成验证码的图片，返回给前台。在这种情况下，校验验证码的工作也只能有后台来完成。当用户量增多时，服务器的压力便会相应地增加。所以，便产生了用前台去分担相应工作的想法。

由于canvas标签方便易用，便用canvas标签来绘制验证码。生成及校验验证码的工作便交由后台。当然，一切工作都可以由前端来完成。但出于安全性的考虑，生成和校验验证码的工作还是交由后端完成。前端只负责绘制。

由于服务器与页面的交互只有字符串并没有图片，而且服务器也无须绘制验证码，这便大大减少了服务器端的压力。

在js实现验证码的示例中，为了演示方便，所以便采用了前端验证。

------------------------------------------
js+php文件夹存放的是js+canvas+php合作完成的验证码功能。

rawphp文件夹存放的是纯php完成的验证码类。

## License
-------------------------------------------
This Project is open-sourced software licensed under the [BSD 3-clause License](https://opensource.org/licenses/BSD-3-Clause).
