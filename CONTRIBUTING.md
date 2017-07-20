# Contributing

Please contribute!

Thanks for your interest and welcome to the Benjamin theme community!  If you're reading this it means your interested in congtributing to Benjamin.  Maybe you found a bug, have have an idea for a new feature or improvement, whatever it is you just wanted to help make Benjamin a better product.

## Why contribute.
I built Benjamin v1 on the side in a couple weeks, the minor versions introduced a lot of planned features, UI/UX improvments, bugs (and squashed bugs too), and WordPress theme standards but it still needs more work. I have a laundry list of new features I want to add, and you probably have some ideas too.  Chances are we are both thinking about the same things which is awesome and why you should contribute.

## How to contribute

Just fork this repo, make some changes and submit a PR!  I am still working out the details about what my general philosophies are on the project, how I'd like to see the go, ect ect ect so not every PR will be accepted.  Hopefully I can be proactive and write up some guidlines soon but that's a way off.  I did have some initial thoughts tho..


## Philosophies

WordPress is not just for developers, its also for content producers.  In fact, I would say its mostly for content providers.  With that in mind - before you submit a PR (or even start working on a feature) I think it's important to ask your self: "Is this easy for the end user to use?"  

### Usability
For instance - one thing I don't like is forcing the user to leave their current screen to change similar settings.  So the header image for example.  Yeah WordPress provides the header image and video out of the box (with better options no less) BUT you'll notice that Benjamin has a group of settings for various template types.  If I had done things the WordPress way, users would have to navigate into a template settings section (like the Frontpage section), configure their settings, then navigate back out over to header and then change the header there. Then if they decide to change something else in the template they would need to navigate out of header, and back over to template.  Why should they do that? I already have a section for all of that template's settings, the header settings should be right there too.

That's also the inspiration for the sortable components control.  The first iteration was just a dropdown with every possible combination as the options.  Gross.
