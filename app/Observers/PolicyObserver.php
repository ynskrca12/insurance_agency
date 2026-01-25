<?php

namespace App\Observers;

use App\Models\Policy;
use App\Models\CariHesap;
use App\Models\CariHareket;

class PolicyObserver
{
    /**
     * Poliçe oluşturulduğunda cari kayıtları oluştur
     */
    public function created(Policy $policy)
    {
        // 1. Müşteri cari hesabını al veya oluştur
        $musteriCari = $policy->customer->getOrCreateCariHesap();

        // 2. Şirket cari hesabını al veya oluştur
        $sirketCari = $this->getOrCreateSirketCari($policy->insuranceCompany);

        // 3. Müşteri carisine BORÇ kaydı (müşteri bize borçlu)
        CariHareket::create([
            'tenant_id' => $policy->tenant_id,
            'cari_hesap_id' => $musteriCari->id,
            'islem_tipi' => 'borc',
            'tutar' => $policy->premium_amount,
            'aciklama' => "Poliçe Primi - {$policy->policy_number} ({$policy->policy_type_label})",
            'referans_tip' => 'policy',
            'referans_id' => $policy->id,
            'islem_tarihi' => $policy->start_date,
            'vade_tarihi' => $policy->start_date->addDays($musteriCari->vade_gun ?? 30),
            'created_by' => $policy->created_by ?? auth()->id(),
        ]);

        // 4. Şirket carisine ALACAK kaydı (şirkete prim - komisyon kadar borçluyuz)
        $netTutar = $policy->premium_amount - $policy->commission_amount;

        CariHareket::create([
            'tenant_id' => $policy->tenant_id,
            'cari_hesap_id' => $sirketCari->id,
            'islem_tipi' => 'alacak',
            'tutar' => $netTutar,
            'aciklama' => "Poliçe Primi - {$policy->policy_number} (Prim: {$policy->premium_amount}₺ - Komisyon: {$policy->commission_amount}₺)",
            'referans_tip' => 'policy',
            'referans_id' => $policy->id,
            'islem_tarihi' => $policy->start_date,
            'vade_tarihi' => $policy->start_date->addDays(30), // Şirkete ödeme için 30 gün vade
            'created_by' => $policy->created_by ?? auth()->id(),
        ]);
    }

    /**
     * Poliçe güncellendiğinde
     */
    public function updated(Policy $policy)
    {
        // Eğer kritik alanlar değiştiyse (prim, komisyon) cari kayıtları güncelle
        if ($policy->wasChanged(['premium_amount', 'commission_amount'])) {
            // Mevcut cari kayıtları sil
            $policy->cariHareketler()->delete();

            // Yeniden oluştur
            $this->created($policy);
        }
    }

    /**
     * Poliçe silindiğinde cari kayıtları da sil
     */
    public function deleted(Policy $policy)
    {
        $policy->cariHareketler()->delete();
    }

    /**
     * Şirket cari hesabını al veya oluştur
     */
    private function getOrCreateSirketCari($insuranceCompany)
    {
        if ($insuranceCompany->cariHesap) {
            return $insuranceCompany->cariHesap;
        }

        $tenantId = $insuranceCompany->tenant_id;

        return CariHesap::create([
            'tenant_id' => $insuranceCompany->tenant_id ?? auth()->id(),
            'tip' => 'sirket',
            'referans_id' => $insuranceCompany->id,
            'kod' => CariHesap::otomatikKodOlustur('sirket', $tenantId),
            'ad' => $insuranceCompany->name,
            'vade_gun' => 30,
            'aktif' => true,
            'created_by' => auth()->id(),
        ]);
    }
}
