<div class="contactForm__confirmNotice">
	<h3 class="contactForm__confirmNoticeTitle">
		ご入力内容にお間違えがなければ<br>
		送信ボタンを押してください
	</h3>

	<p class="contactForm__confirmNoticeText">まだ送信完了していません</p>
</div>

<div class="contactForm__list h-adr">
	<span class="p-country-name" style="display:none;">Japan</span>

	<dl class="contactForm__item">
		<dt class="contactForm__title -required">ご所属</dt>
		<dd class="contactForm__input -checkboxes -wrap">
			[mwform_radio name="in_belogin_to" id="in_belogin_to" children="丸紅グループ従業員さま,丸紅グループ退職者さま,一般のお客さま" separator=","]
		</dd>
	</dl>

	<dl class="contactForm__item">
		<dt class="contactForm__title -required">所属会社名</dt>
		<dd class="contactForm__input">
			[mwform_text name="in_company_name" id="in_company_name" size="60"]
			<p class="contactForm__placeholder">※出向中の方は出向元の会社名を入力してください</p>
		</dd>
	</dl>

	<dl class="contactForm__item">
		<dt class="contactForm__title">社員番号</dt>
		<dd class="contactForm__input">
			[mwform_text name="in_employee_number" id="in_employee_number" size="60"]
		</dd>
	</dl>

	<dl class="contactForm__item">
		<dt class="contactForm__title -required">お名前</dt>
		<dd class="contactForm__input -col2">
			<div>
				[mwform_text name="in_familiy_name" id="in_familiy_name" size="60"]
				<p class="contactForm__placeholder">例）山田</p>
			</div>
			<div>
				[mwform_text name="in_first_name" id="in_first_name" size="60"]
				<p class="contactForm__placeholder">例）太郎</p>
			</div>
		</dd>
	</dl>

	<dl class="contactForm__item">
		<dt class="contactForm__title -required">フリガナ</dt>
		<dd class="contactForm__input -col2">
			<div>
				[mwform_text name="in_familiy_name_kana" id="in_familiy_name_kana" size="60"]
				<p class="contactForm__placeholder">例）ヤマダ</p>
			</div>
			<div>
				[mwform_text name="in_first_name_kana" id="in_first_name_kana" size="60"]
				<p class="contactForm__placeholder">例）タロウ</p>
			</div>
		</dd>
	</dl>

	<dl class="contactForm__item">
		<dt class="contactForm__title  -required">生年月日</dt>
		<dd class="contactForm__input -checkboxes -wrap">
			[mwform_radio name="in_dob_generation" id="in_dob_generation" children="平成,昭和,大正" separator=","]
			<br>
			<div class="-dob">
				<div class="-dob-item">[mwform_text name="in_dob_year" id="in_dob_year" size="2" max="99"] <span class="-unit">年</span></div>
				<div class="-dob-item">[mwform_text name="in_dob_month" id="in_dob_month" size="2" max="12"] <span class="-unit">月</span></div>
				<div class="-dob-item">[mwform_text name="in_dob_date" id="in_dob_date" size="2" max="31"] <span class="-unit">日</span></div>
			</div>

			<p class="contactForm__placeholder">例）05年 04月 01日　※半角で入力してください</p>
		</dd>
	</dl>

	<dl class="contactForm__item">
		<dt class="contactForm__title -required">日中のご連絡先</dt>
		<dd class="contactForm__input -checkboxes">
			[mwform_radio name="in_contact" id="in_contact" children="携帯,会社,自宅" separator=","]
		</dd>
	</dl>

	<dl class="contactForm__item">
		<dt class="contactForm__title  -required">電話番号</dt>
		<dd class="contactForm__input">
			[mwform_tel name="in_tel"]
		</dd>
	</dl>

	<dl class="contactForm__item">
		<dt class="contactForm__title -required">メールアドレス</dt>
		<dd class="contactForm__input">
			[mwform_email name="in_email" id="in_email" size="60"]

			<p class="contactForm__placeholder">※半角で入力してください</p>
		</dd>
	</dl>

	<dl class="contactForm__item">
		<dt class="contactForm__title -required">お問い合わせ<br>保険種目</dt>
		<dd class="contactForm__input -checkboxes -wrap">
			[mwform_checkbox name="in_insurance" id="in_insurance" children="自動車保険,火災保険,医療・がん保険,傷害保険（ケガ・個人賠償）,その他" separator=","]
		</dd>
	</dl>

	<dl class="contactForm__item">
		<dt class="contactForm__title -required">お問い合わせ概要</dt>
		<dd class="contactForm__input -checkboxes -wrap">
			[mwform_checkbox name="in_contact_about" id="in_contact_about" children="現在のご契約について,新規契約を検討中,資料請求,事故に関するお問い合わせ,その他" separator=","]
		</dd>
	</dl>

	<dl class="contactForm__item -hide">
		<dt class="contactForm__title">証券番号</dt>
		<dd class="contactForm__input">
			[mwform_text name="in_policy_number" id="in_policy_number" size="60"]
		</dd>
	</dl>

	<dl class="contactForm__item">
		<dt class="contactForm__title">保険会社名</dt>
		<dd class="contactForm__input">
			[mwform_text name="in_insurance_company_name" id="in_insurance_company_name" size="60"]
		</dd>
	</dl>

	<dl class="contactForm__item">
		<dt class="contactForm__title">お問い合わせ内容</dt>
		<dd class="contactForm__input">
			<p class="contactForm__inputText">
				事故で至急対応が必要な場合は<a class="-pen" id="insurance_link" href="[sc_home_url link=/employee/claims/]">直接保険会社へご連絡</a>ください。<br>
				お問い合わせ種目/概要で「その他」を選択された方は詳細をご入力ください。<br>
				ご家族の保障に関するお問い合わせの場合は、対象の方の氏名・続柄・生年月日もご入力ください。
			</p>
			[mwform_textarea name="in_notes" id="in_notes" cols="50" rows="5"]
		</dd>
	</dl>

	<dl class="contactForm__item  -hide">
		<dt class="contactForm__title">郵便番号</dt>
		<dd class="contactForm__input">
			<p class="contactForm__inputText">
				見積書送付、資料請求、保険金請求書類送付をご希望の方はご入力をお願いします。
			</p>

			[mwform_text name="in_post_number" id="in_post_number" class="p-postal-code" size="8" maxlength="8"]

			<p class="contactForm__placeholder">※半角で入力してください</p>
		</dd>
	</dl>

	<dl class="contactForm__item -hide">
		<dt class="contactForm__title">住所</dt>
		<dd class="contactForm__input">
			[mwform_text name="in_address" id="in_address" class="p-region p-locality p-street-address p-extended-address" size="60"]
		</dd>
	</dl>
</div>

<div class="contactForm__confirm">
	<h3 class="contactForm__confirmTitle">個人情報保護方針について</h3>

	<div class="contactForm__confirmText">
		<p>
			当社は、個人情報保護の重要性に鑑み、また、損害保険代理業務・生命保険募集業務などの保険代理業における当社の信頼をより向上させるため、個人情報の取り扱いに関する法令・国が定める指針、その他の規範を遵守して、個人情報を適正に取り扱うと共に、安全管理について適切な措置を講じます。当社は、社内体制の整備や社員教育などを通じ個人情報保護意識の高揚に努め、個人情報の取り扱いが適正に行われるよう取り組んでまいります。また、個人情報の取り扱いに関する苦情・相談に迅速に対応し、当社の個人情報の取り扱い及び安全管理に係る適切な措置については、適宜見直し、改善いたします。<br>
			こうした措置は当社の重要な社会的責務と認識しています。 当社は、かかる認識の下、以下の個人情報保護方針によって個人情報を取り扱います。<br><br><br>
		</p>

		<ul>
			<li>１．当社は事業活動に必要な範囲に限定して、利用目的を明確に定め、適切に個人情報の取得、利用および提供を行います。取得した個人情報は利用目的の範囲内で適法・公正に利用し、目的外利用を行わないための措置を講じます。</li>
			<li>２．当社は個人情報の取り扱いに関する法令、国が定める指針及びその他の規範を遵守します。</li>
			<li>３．当社は保有する個人情報の漏洩、滅失または毀損を防止するため、合理的な対策を講じるとともに、必要な是正措置を講じます。</li>
			<li>４．当社は個人情報の取り扱い及び個人情報保護に関する取り組みに関する苦情及び相談窓口を設置し、対応いたします。</li>
			<li>５．当社は個人情報保護マネジメントシステムを継続的に見直し、改善を行います。</li>
		</ul>

		<p>
			制定日　2013年4月1日<br>
			改訂日　2022年4月1日<br>
			丸紅セーフネット株式会社<br>
			代表取締役社長　大川　達哉<br><br><br>
		</p>

		<p>
			お問い合わせ窓口<br>
			丸紅セーフネット株式会社 経営管理部<br>
			〒102-0084 東京都千代田区二番町3番地 麹町スクエア3階<br>
			TEL: 03-5210-1610／FAX: 03-5210-1600<br>
			e-mail: privacy@m-inc.co.jp<br>
			受付時間：9：15～17：30（平日）
		</p>
	</div>

	<div class="contactForm__confirmCheckbox">
		[mwform_checkbox name="confirm" children="個人情報保護方針に同意する " separator=","]
	</div>
</div>

<div class="contactForm__submitWrap">
	<div class="contactForm__buttonWrap -submit">
		[mwform_submitButton name="in_submit" confirm_value="確認する" submit_value="送信する"]
		[mwform_backButton value="修正する"]
	</div>
</div>
