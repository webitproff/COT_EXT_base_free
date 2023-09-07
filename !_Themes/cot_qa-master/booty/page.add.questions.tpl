<!-- BEGIN: MAIN -->

		<div class="block">
			<h2 class="page">{PHP.L.addquestionform}</h2>
			{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
			<div class="customform">
			<form action="{PAGEADD_FORM_SEND}" enctype="multipart/form-data" method="post" name="pageform">
				<table class="table">
					<tr>
						<td class="width30">{PHP.L.Category}:</td>
						<td class="width70">{PAGEADD_FORM_CAT_SHORT}</td>
					</tr>
					<tr>
						<td>{PHP.L.Question}:</td>
						<td>{PAGEADD_FORM_TITLE}</td>
					</tr>
					<tr class="hidden">
						<td>{PHP.L.Description}:</td>
						<td>{PAGEADD_FORM_DESC}</td>
					</tr>
					<tr class="hidden">
						<td>{PHP.L.Author}:</td>
						<td>{PAGEADD_FORM_AUTHOR}</td>
					</tr>
					<tr class="hidden">
						<td>{PHP.L.Alias}:</td>
						<td>{PAGEADD_FORM_ALIAS}</td>
					</tr>
					<tr class="hidden">
						<td>{PHP.L.page_metakeywords}:</td>
						<td>{PAGEADD_FORM_KEYWORDS}</td>
					</tr>
					<tr class="hidden">
						<td>{PHP.L.page_metatitle}:</td>
						<td>{PAGEADD_FORM_METATITLE}</td>
					</tr>
					<tr class="hidden">
						<td>{PHP.L.page_metadesc}:</td>
						<td>{PAGEADD_FORM_METADESC}</td>
					</tr>
<!-- BEGIN: TAGS -->
					<tr>
						<td>{PAGEADD_TOP_TAGS}:</td>
						<td>{PAGEADD_FORM_TAGS} ({PAGEADD_TOP_TAGS_HINT})</td>
					</tr>
<!-- END: TAGS -->
					<tr class="hidden">
						<td>{PHP.L.Owner}:</td>
						<td>{PAGEADD_FORM_OWNER}</td>
					</tr>
					<tr class="hidden">
						<td>{PHP.L.Begin}:</td>
						<td>{PAGEADD_FORM_BEGIN}</td>
					</tr>
					<tr class="hidden">
						<td>{PHP.L.Expire}:</td>
						<td>{PAGEADD_FORM_EXPIRE}</td>
					</tr>
					<tr class="hidden">
						<td>{PHP.L.Parser}:</td>
						<td>{PAGEADD_FORM_PARSER}</td>
					</tr>
					<tr>
						<td colspan="2">
							{PAGEADD_FORM_TEXT}
							<!-- IF {PAGEADD_FORM_PFS} -->{PAGEADD_FORM_PFS}<!-- ENDIF -->
							<!-- IF {PAGEADD_FORM_SFS} --><span class="spaced">{PHP.cfg.separator}</span>{PAGEADD_FORM_SFS}<!-- ENDIF -->
						</td>
					</tr>
					<tr class="hidden">
						<td>{PHP.L.page_file}:</td>
						<td>
							{PAGEADD_FORM_FILE}
							<p>{PHP.L.page_filehint}</p>
						</td>
					</tr>
					<tr class="hidden">
						<td>{PHP.L.URL}:<br />{PHP.L.page_urlhint}</td>
						<td>{PAGEADD_FORM_URL}<br />{PAGEADD_FORM_URL_PFS} &nbsp; {PAGEADD_FORM_URL_SFS}</td>
					</tr>
					<tr class="hidden">
						<td>{PHP.L.Filesize}:<br />{PHP.L.page_filesizehint}</td>
						<td>{PAGEADD_FORM_SIZE}</td>
					</tr>
					<tr>
						<td colspan="2" class="valid">
						
							<!-- IF {PHP.usr.id} == 0 -->
							<input type="hidden" name="rpageparser" value="none">
							<!-- ENDIF -->
							
							<!-- IF {PHP.usr_can_publish} -->
							<button type="submit" class="btn" name="rpagestate" value="0">{PHP.L.Publish}</button>
							<!-- ENDIF -->
							<!-- IF {PHP.usr.id} > 0 -->
							<button type="submit" class="btn" name="rpagestate" value="2">{PHP.L.Saveasdraft}</button>
							<!-- ENDIF -->
							<button type="submit" class="btn" name="rpagestate" value="1">{PHP.L.Submitforapproval}</button>
						</td>
					</tr>
				</table>
			</form>
			</div>
		</div>

<!-- END: MAIN -->