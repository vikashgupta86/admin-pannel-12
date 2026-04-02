<?php



$sql = "select mc.m_cat_id,mc.cat_name,mc.cat_name_h,mt.m_temp_id,mt.image_name,mt.m_description,mt.m_description_h  from web_media_final mf
                      INNER JOIN web_media_temp mt on mt.m_temp_id=mf.m_temp_id
                      INNER JOIN web_media_category mc on mc.m_cat_id=mt.m_cat_id
                      where mf.status='Active' and mt.status='Active' and mc.status='Active' and mt.image_name is not null and  mf.gallery_flage=1 and mc.app_reject=1 and mf.publish_date<=CURDATE() order by mf.pos";




$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$rows = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<div class="container-fluid carousel bg-light px-0">
    <div class="row g-0 justify-content-end">
        <div class="header-carousel owl-carousel bg-light py-0 dis_none">

            <?php if (!empty($rows)): ?>
                <?php foreach ($rows as $row): ?>

                    <div class="row g-0 header-carousel-item align-items-center">
                        <div class="carousel-img wow fadeInLeft" data-wow-delay="0.1s">
                            <img 
                                src="WriteReadData/MD32145/<?= safeFile($row['image_name']); ?>"
                                class="img-fluid w-100" style="height: 660px;"
                                alt="<?= ($row['m_description'] != '') ? e(html_entity_decode($row['m_description'])) : ''; ?>"
                            >
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
</div>