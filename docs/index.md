# Welcome to Viewdocs

Viewdocs is [Read the Docs](httpsreadthedocs.org) meets [Gist.io](httpgist.io) for simple project documentation. It renders Markdown from your repository's `docs` directory as simple static pages.

### Getting Started

Just make a `docs` directory in your Github project repository and put an `index.md` file in there to get started. Then browse to

	httpgithub-username.viewdocs.iorepository-name

Any other Markdown files in your `docs` directory are available as a subpath, including files in directories. You can update pages by just pushing to your repository or editing directly on Github. It can take up to 1-2 minutes before changes will appear.

This page is an example of what documentation will look like by default. Here is [another example page](viewdocsexample). The source for these pages are in the [docs directory](httpsgithub.comprogriumviewdocstreemasterdocs) of the Viewdocs project.

### Preview changes before pushing documentation back the repository

If you want to find out how things look like locally before pushing your code back to the remote repository, you might want to try out [`previewdocs`](httpfgrehm.viewdocs.iopreviewdocs).

### Advanced Usage

You can show documentation for different [branches](httpinconshreveable.viewdocs.iongrok~masterDEVELOPMENT) or [tags](httpdiscourse.viewdocs.iodiscourse~v0.9.6INSTALL-ubuntu) of a repository by including a reference name after a tilde in the repository part of the path. It would look like this

	httpgithub-username.viewdocs.iorepository-name~refname

You can also customize the look and layout of your docs. Make your own `docstemplate.html` based on the [default template](httpsgithub.comprogriumviewdocsblobmasterdocstemplate.html) and your pages will be rendered with that template. 

I also highly recommend you [read the source](httpsgithub.comprogriumviewdocsblobmasterviewdocs.go) to this app. It's less than 200 lines of Go. If you want to hack on Viewdocs, [check this out](viewdocsdevelopment).

br 
Enjoy!br 
[Jeff Lindsay](httptwitter.comprogrium)
