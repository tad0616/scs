
<h4>升學意願（不升學者免填）</h4>
<div class="alert alert-info">
    <textarea name="scs_students[post_graduation_plan][further_education]" id="further_education" class="form-control"><{$student.post_graduation_plan.further_education}></textarea>
</div>

<h4>就業意願（升學者免填）</h4>
<div class="alert alert-success">
    <textarea name="scs_students[post_graduation_plan][employment]" id="employment" class="form-control"><{$student.post_graduation_plan.employment}></textarea>
</div>

<h4>如未能升學希望參加職業訓練種類及地區</h4>
<div class="alert alert-info">
    <div class="form-group row custom-gutter">
        <label class="col-sm-2 col-form-label text-md-right control-label">
            職訓種類：
        </label>
        <div class="col-sm-4">
            <input type="text" name="scs_students[post_graduation_plan][training_kind]" id="training_kind" class="form-control " value="<{$student.post_graduation_plan.training_kind}>" placeholder="職訓種類">
        </div>
        <label class="col-sm-2 col-form-label text-md-right control-label">
            受訓地區：
        </label>
        <div class="col-sm-4">
            <input type="text" name="scs_students[post_graduation_plan][training_zone]" id="training_zone" class="form-control " value="<{$student.post_graduation_plan.training_zone}>" placeholder="受訓地區">
        </div>
    </div>
</div>

<h4>將來職業意願</h4>
<div class="alert alert-info">
    <div class="form-group row custom-gutter">
        <label class="col-sm-2 col-form-label text-md-right control-label">
            職業種類：
        </label>
        <div class="col-sm-4">
            <input type="text" name="scs_students[post_graduation_plan][job_kind]" id="job_kind" class="form-control " value="<{$student.post_graduation_plan.job_kind}>" placeholder="職業種類">
        </div>
        <label class="col-sm-2 col-form-label text-md-right control-label">
            就業地區：
        </label>
        <div class="col-sm-4">
            <input type="text" name="scs_students[post_graduation_plan][job_zone]" id="job_zone" class="form-control " value="<{$student.post_graduation_plan.job_zone}>" placeholder="就業地區">
        </div>
    </div>
</div>