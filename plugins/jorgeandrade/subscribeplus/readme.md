##Before start
Before you install this plugin, please install the plugin called **JorgeAndrade.SubscribeForm**.

## Front-end subscribe
Put the component where you want get the form subscribe inside a page in October CMS. Edit the properties as you want.

```
{% component 'subscribeformplus' %}
```

##Campaign Templates
Campaign Templates should be designed by a developer.
There is a template build syntax, this let you render a modal view inside **Campaign update view**  after clicking the button **edit** inside the template. These markup tags are supported:

###Simple Text
Renders a **Form input type text**,  this can be used in any html text tag (p, span, h1, etc.)
```
<h3 data-editable="simpleText" id="edit-subject">Example text</h3>
```

###Simple Textarea
Renders a **Form textarea**,  this can be used in any html text tag, but it is perfect for long text **<p>**
```
<p data-editable="simpleTextarea" id="edit-textarea">Contact Info</p>
```

###Rich Editor
Renders a **richEditor**,  this only can be used in a **<div>** tag
```
<div data-editable="richEditor" id="edit-rich">Description</div>
```

###Image
Renders a **Media Manager**,  the data-editable attribute must be used in the **<img>** tag and this must be within a div with class **editable**
```
<div class="editable" >
    <img src="http://andradedev.com/themes/andradedev/assets/images/andrademail/logo.png" id="logo" data-editable="image" width="200">
</div>
```

###Social Links
Renders a **Form input type text** and a list of **Brand Icons**,  this only can be used in a **<div>** tag. It allows you to add links to your Social Networks
```
<div data-editable="socialLinks"></div>
```

###Social Link
Like a **Social Links**, render a **Form input type text** and a list of **Brand Icons**, but the difference is that social networks can add default. The data-editable attribute must be used in the **<a>** tag and inside this a **<img>** tag with the link to your icon.
```
<a href="#" id="facebook" data-editable="socialLink">
    <img src="http://andradedev.com/themes/andradedev/assets/images/andrademail/facebook.jpg" alt="" />
</a>
```

All the markup tags use two attributes: **data-editable** and **id**. The data-editable attribute is required and the value must be exactly as shown above. The id attribute is optional, if not put an automatic id is generated.

### Creating your first template
To create a template, you need a file structure:

```
andredemail <-- folder name
|-->index.htm
|--> preview.htm
|-->header.txt
|-->footer.txt
|-->template.json
```

The index.htm file contains the basic template and ready for use in campaigns.
The preview.htm file contains a complete template example for preview.
The header file contains the document header, for example:
```
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic,900|Open+Sans|Roboto">
    <title>Template Name</title>

</head>

<body>
    <div id="export-html">
```

Note that a div within the tag body with **export-html** id is added, it will serve in the process of editing the campaign

The footer file contains the document footer, for example:
````
        </div>
    </body>
</html>
````

The template.json file contains the template information, as well as information of the modules and the list of icons.
````
{
    "name": "Andrade Mail",
    "code": "andredemail",
    "description": "Andrademail Default Theme",
    "author": "Jorge Andrade",
    "modules": [
        {
            "id": "fullWidthImage",
            "name": "Full Banner",
            "html": "<tr class=\"sorted\"><td align=\"center\" valign=\"top\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tr><td align=\"center\" valign=\"top\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" class=\"flexibleContainer\"><tr><td align=\"center\" valign=\"top\" width=\"600\" class=\"flexibleContainerCell\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tr><td valign=\"top\" class=\"imageContent\"><div class=\"editable\"><img src=\"http://placekitten.com/g/1120/800\" data-editable=\"image\" width=\"560\" class=\"flexibleImage\" style=\"max-width:560px;\" /></div></td></tr></table></td></tr></table></td></tr></table></td></tr>"
        },
        {
            "id": "separator",
            "name":"Separator",
            "html": "<tr class=\"sorted\"><td align=\"center\" valign=\"top\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tr><td align=\"center\" valign=\"top\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" class=\"flexibleContainer\"><tr><td align=\"center\" valign=\"top\" width=\"600\" class=\"flexibleContainerCell\"><hr class=\"separator\" /></td></tr></table></td></tr></table></td></tr>"
        }
    ],
    "icons": [
        {
            "id": "rss",
            "img": "http://andradedev.com/themes/andradedev/assets/images/andrademail/rss.jpg"
        },
        {
            "id": "facebook",
            "img": "http://andradedev.com/themes/andradedev/assets/images/andrademail/facebook.jpg"
        },
        {
            "id": "twitter",
            "img": "http://andradedev.com/themes/andradedev/assets/images/andrademail/twitter.jpg"
        }
    ]
}
````

The folder name must exactly match the property **code** file template.json.

Finally compress everything into a .zip file with the name of the property **code** file template.json and import you new template.