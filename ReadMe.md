###Untrack files already added to git repository based on .gitignore
* Let’s say you have already added/committed some files to your git repository and you then add them to your .gitignore;<br />  
these files will still be present in your repository index. This article we will see how to get rid of them. 
[Untrack files in Git](http://www.codeblocq.com/2016/01/Untrack-files-already-added-to-git-repository-based-on-gitignore/)
    
### Step 1: Commit all your changes

* Before proceeding, make sure all your changes are committed, including your .gitignore file.
###Step 2: Remove everything from the repository

* To clear your repo, use:

```
 git rm -r --cached .           ====>       (all files)
 git rm -r --cached .idea       ====>       (selected file .idea)
```
* `rm`  : is the remove command
* `-r`  : will allow recursive removal
* `–cached` :  will only remove files from the index. Your files will still be there.
The . indicates that all files will be untracked. You can untrack a specific file with 
    * `git rm --cached .idea` 

* The rm command can be unforgiving. If you wish to try what it does beforehand, add the `-n` or `--dry-run flag` to test things out.
### Step 3: Re add everything

* `git add .`

### Step 4: Commit

* `git commit -m ".idea"`

Your repository is clean :)

Push the changes to your remote to see the changes effective there as well.