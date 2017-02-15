# github-repo-displayer
This is PHP library that allows users to get the info needed to display their repos on their personal site.



## Usage
While the libaray can extract basic data for each repo from the Github API, users including myself might want to have more control over the specific content returned for each repository. Shown below is the syntax used to add extra details to your repositories. This needs to be added in the README.md file for each repository. This libaray doesn't require all or any of these properties to be used. We surround the code in a comment block so that it doesn't show up when looking at the README file (only in the raw version).
```
<!--
[**GITHUBPHPPARSER**]
{
  "AltShortDesc": "This is the Short DESC",
  "LongDesc": "This is the Ling DSEC",
  "ImgURL": "http://www.google.com",
  "ThumbailImgURL": "http://www.google.org",
  "Category": "Test Category\n"
}
[**GITHUBPHPPARSER**]
-->
```

### Notice
This libaray doesn't provide anyway to cache the results returned. If this going to be used on a site, the results returned from this libaray should be cached and updated daily as not to overload Github's API with unnecessary calls.


## Updates
Updates to this libaray will be made if there is a bug found or something changes with the Github API. Please open an issue on Github for all bugs/issues found. I will also be adding in new properties that the libaray returns when necessary.
