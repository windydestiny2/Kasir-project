"""
Decision Support System for Kasir-Project
Provides actionable insights and recommendations based on ML predictions
"""

import pandas as pd
import numpy as np
from datetime import datetime, timedelta

class DecisionSupportEngine:
    """Generate business insights and recommendations based on ML predictions"""
    
    def __init__(self):
        self.day_names = {
            1: 'Senin', 2: 'Selasa', 3: 'Rabu', 4: 'Kamis',
            5: 'Jumat', 6: 'Sabtu', 7: 'Minggu'
        }

    # ========================
    # MENU RECOMMENDATION INSIGHTS
    # ========================
    
    def get_menu_insights(self, recommendations, df=None):
        """
        Generate insights for menu recommendations
        
        Args:
            recommendations: List of recommended menu items with scores
            df: Training dataframe for co-purchase analysis
            
        Returns:
            List of insights with actionable recommendations
        """
        insights = []
        
        if not recommendations:
            return insights
        
        # Get top 2-3 recommendations
        top_menus = recommendations[:3]
        menu_names = [r.get('menu_name', 'Unknown') for r in top_menus]
        
        if len(top_menus) >= 2:
            primary_menu = menu_names[0]
            secondary_menu = menu_names[1]
            
            # Main insight: Co-purchase recommendation
            insight = {
                "type": "co_purchase",
                "confidence": "high",
                "title": "Rekomendasi Menu & Strategi Promosi",
                "reasoning": self._generate_covisited_reasoning(menu_names, top_menus),
                "actions": self._generate_menu_actions(top_menus, menu_names),
                "supplies": self._generate_supply_recommendations(top_menus),
                "priority": "high"
            }
            insights.append(insight)
        
        # Bundle recommendation based on popularity patterns
        if len(top_menus) >= 2:
            bundle_insight = self._generate_bundle_insight(top_menus)
            if bundle_insight:
                insights.append(bundle_insight)
        
        # Stock preparation insight
        stock_insight = {
            "type": "stock_planning",
            "confidence": "high",
            "title": "Persiapan Bahan Baku",
            "reasoning": self._generate_stock_reasoning(top_menus),
            "actions": self._generate_stock_actions(top_menus),
            "priority": "high"
        }
        insights.append(stock_insight)
        
        return insights

    def _generate_covisited_reasoning(self, menu_names, recommendations):
        """Generate reasoning for co-purchase patterns"""
        if len(menu_names) < 2:
            return f"Menu {menu_names[0]} sangat banyak diminati hari ini."
        
        primary = menu_names[0]
        secondary = menu_names[1]
        third = menu_names[2] if len(menu_names) > 2 else None
        
        # Calculate popularity comparison
        primary_score = recommendations[0].get('popularity_score', 0)
        secondary_score = recommendations[1].get('popularity_score', 0)
        
        score_diff = ((primary_score - secondary_score) / secondary_score * 100) if secondary_score > 0 else 0
        
        base_reasoning = (
            f"Berdasarkan analisis pola pembelian, "
            f"{primary} dan {secondary} adalah menu yang paling banyak dibarengi "
            f"dalam transaksi hari ini. {primary} memiliki tingkat popularitas "
            f"{score_diff:.1f}% lebih tinggi dari {secondary}."
        )
        
        if third:
            base_reasoning += f" Sementara {third} juga menunjukkan pola pembelian yang kuat."
        
        return base_reasoning

    def _generate_menu_actions(self, recommendations, menu_names):
        """Generate action items for menu strategy"""
        actions = []
        
        # Primary menu action
        primary_menu = menu_names[0]
        primary_orders = recommendations[0].get('order_count', 0)
        
        actions.append({
            "priority": 1,
            "action": f"Utamakan promosi untuk {primary_menu}",
            "detail": f"Menu ini memiliki {primary_orders} penjualan dengan tingkat kepuasan tinggi",
            "impact": "Tingkatkan penjualan & customer satisfaction"
        })
        
        # Cross-selling action
        if len(menu_names) >= 2:
            secondary_menu = menu_names[1]
            actions.append({
                "priority": 2,
                "action": f"Bundling {primary_menu} + {secondary_menu}",
                "detail": "Kedua menu sering dibeli bersama, ideal untuk paket hemat",
                "impact": "Increase average transaction value"
            })
        
        # Placement action
        actions.append({
            "priority": 2,
            "action": f"Tempatkan {primary_menu} di posisi strategis",
            "detail": "Letakkan di display utama atau di awal menu",
            "impact": "Memudahkan customer menemukan menu terpopuler"
        })
        
        return actions

    def _generate_supply_recommendations(self, recommendations):
        """Generate supply/ingredient recommendations"""
        supplies = []
        
        for idx, rec in enumerate(recommendations[:3]):
            menu_name = rec.get('menu_name', 'Unknown')
            qty = rec.get('total_qty', rec.get('order_count', 0))
            percent = rec.get('percent', 0)
            
            # Calculate supply multiplier based on popularity
            if percent > 20:
                multiplier = 1.5
                level = "BANYAK"
            elif percent > 10:
                multiplier = 1.3
                level = "NORMAL"
            else:
                multiplier = 1.1
                level = "STANDAR"
            
            supplies.append({
                "rank": idx + 1,
                "menu": menu_name,
                "level": level,
                "expected_qty": int(qty * multiplier),
                "base_qty": int(qty),
                "percentage": f"{percent:.1f}%",
                "note": f"Persiapkan bahan baku untuk {menu_name} {level} (naik {((multiplier-1)*100):.0f}%)"
            })
        
        return supplies

    def _generate_stock_reasoning(self, recommendations):
        """Generate reasoning for stock preparation"""
        total_orders = sum(r.get('order_count', 0) for r in recommendations[:3])
        
        if total_orders > 50:
            intensity = "SANGAT TINGGI"
        elif total_orders > 30:
            intensity = "TINGGI"
        else:
            intensity = "SEDANG"
        
        return (
            f"Dengan intensitas pembelian {intensity} (estimasi {total_orders} order), "
            f"persiapan bahan baku perlu ditingkatkan untuk mencegah kehabisan stok dan "
            f"memastikan service quality tetap terjaga."
        )

    def _generate_stock_actions(self, recommendations):
        """Generate specific stock actions"""
        actions = []
        
        for rec in recommendations[:3]:
            menu_name = rec.get('menu_name', 'Unknown')
            qty = rec.get('total_qty', rec.get('order_count', 0))
            
            actions.append({
                "item": menu_name,
                "priority": "HIGH" if qty > 30 else "MEDIUM",
                "action": f"Siapkan {int(qty * 1.3)} porsi {menu_name}",
                "detail": f"Berdasarkan rerata penjualan {int(qty)} porsi, tingkatkan hingga 30% untuk buffer"
            })
        
        return actions

    def _generate_bundle_insight(self, recommendations):
        """Generate bundle/paket recommendations"""
        if len(recommendations) < 2:
            return None
        
        primary = recommendations[0]
        secondary = recommendations[1]
        
        primary_name = primary.get('menu_name', 'Menu A')
        secondary_name = secondary.get('menu_name', 'Menu B')
        
        primary_price = primary.get('avg_price', 0)
        secondary_price = secondary.get('avg_price', 0)
        total_price = primary_price + secondary_price
        bundle_discount = int(total_price * 0.1)  # 10% discount
        bundle_price = total_price - bundle_discount
        
        return {
            "type": "bundle_offer",
            "confidence": "medium",
            "title": "Rekomendasi Paket Bundle",
            "reasoning": (
                f"Pola pembelian menunjukkan {primary_name} dan {secondary_name} sering dibeli bersama. "
                f"Penawaran paket bundle dapat meningkatkan average order value."
            ),
            "actions": [{
                "action": f"Tawarkan Paket {primary_name} + {secondary_name}",
                "price_breakdown": f"Normal: Rp {total_price:,} → Bundle: Rp {bundle_price:,} (hemat Rp {bundle_discount:,})",
                "expected_uplift": "10-15% peningkatan average transaction value"
            }],
            "priority": "medium"
        }

    # ========================
    # REVENUE PREDICTION INSIGHTS
    # ========================
    
    def get_revenue_insights(self, revenue_prediction, seasonal_patterns=None):
        """
        Generate insights for revenue predictions
        
        Args:
            revenue_prediction: Revenue forecasting data
            seasonal_patterns: Seasonal pattern analysis data
            
        Returns:
            List of insights with actionable recommendations
        """
        insights = []
        
        if not revenue_prediction:
            return insights
        
        # Analyze current day's predicted revenue
        predicted_revenue = revenue_prediction.get('prediction', {}).get('predicted_revenue', 0)
        confidence = revenue_prediction.get('prediction', {}).get('confidence_interval', {})
        
        # Get historical stats for comparison
        model_info = revenue_prediction.get('model_info', {})
        avg_revenue = model_info.get('training_avg_revenue', 0)
        
        # Revenue performance insight
        perf_insight = self._generate_revenue_performance_insight(
            predicted_revenue, avg_revenue, confidence
        )
        insights.append(perf_insight)
        
        # Staffing recommendation
        staffing_insight = self._generate_staffing_insight(
            predicted_revenue, avg_revenue
        )
        insights.append(staffing_insight)
        
        # Operational efficiency insight
        if seasonal_patterns:
            ops_insight = self._generate_operational_insight(
                predicted_revenue, seasonal_patterns
            )
            insights.append(ops_insight)
        
        # Cost optimization insight
        cost_insight = self._generate_cost_optimization_insight(
            predicted_revenue, avg_revenue
        )
        insights.append(cost_insight)
        
        return insights

    def _generate_revenue_performance_insight(self, predicted, average, confidence):
        """Generate revenue performance analysis"""
        if average == 0:
            percentage_diff = 0
            status = "NORMAL"
            trend = "stabil"
        else:
            percentage_diff = ((predicted - average) / average) * 100
            
            if percentage_diff > 20:
                status = "SANGAT BAGUS"
                trend = "meningkat signifikan"
            elif percentage_diff > 0:
                status = "BAGUS"
                trend = "meningkat"
            elif percentage_diff > -20:
                status = "MENURUN"
                trend = "sedikit menurun"
            else:
                status = "RENDAH"
                trend = "menurun signifikan"
        
        lower_bound = confidence.get('lower', predicted * 0.9)
        upper_bound = confidence.get('upper', predicted * 1.1)
        
        return {
            "type": "revenue_performance",
            "confidence": "high",
            "title": "Analisis Performa Pendapatan Hari Ini",
            "status": status,
            "reasoning": (
                f"Prediksi pendapatan hari ini adalah Rp {predicted:,.0f}, "
                f"yang {trend} dibandingkan rata-rata historis Rp {average:,.0f} ({percentage_diff:+.1f}%). "
                f"Range prediksi: Rp {lower_bound:,.0f} - Rp {upper_bound:,.0f} dengan confidence 95%."
            ),
            "performance_metrics": {
                "predicted": predicted,
                "average": average,
                "difference": predicted - average,
                "percentage_diff": percentage_diff,
                "confidence_lower": lower_bound,
                "confidence_upper": upper_bound
            },
            "priority": "high"
        }

    def _generate_staffing_insight(self, predicted, average):
        """Generate staffing recommendations"""
        if predicted <= 0:
            return None
        
        # Calculate required staff based on revenue
        # Assumptions: 1 staff can handle ~200k revenue effectively
        base_staff = max(1, round(predicted / 200000))
        
        if predicted < average * 0.5:
            staff_recommendation = max(1, base_staff - 1)
            action = f"Kurangi staff menjadi {staff_recommendation} orang atau gunakan part-time staff"
            reasoning = (
                f"Prediksi pendapatan {(1 - predicted/average)*100:.0f}% lebih rendah dari rata-rata. "
                f"Mengurangi staff akan mengoptimalkan ratio labor cost terhadap revenue."
            )
            cost_impact = f"Hemat labor cost ~{((average - predicted)/200000*1000000):.0f}k"
            
        elif predicted < average * 0.8:
            staff_recommendation = base_staff
            action = f"Pertahankan staff normal ({staff_recommendation} orang)"
            reasoning = (
                f"Pendapatan sedikit di bawah rata-rata. Pertahankan staff normal "
                f"untuk menjaga service quality."
            )
            cost_impact = "Biaya operasional terkontrol"
            
        elif predicted < average * 1.2:
            staff_recommendation = base_staff
            action = f"Pertahankan staffing ({staff_recommendation} orang)"
            reasoning = f"Pendapatan dalam range normal. Staf cukup untuk menangani volume yang diharapkan."
            cost_impact = "Balanced antara service quality dan cost"
            
        else:
            staff_recommendation = base_staff + 1
            action = f"Tambah staff menjadi {staff_recommendation} orang"
            reasoning = (
                f"Prediksi pendapatan {(predicted/average - 1)*100:.0f}% lebih tinggi dari rata-rata. "
                f"Tambah staff untuk memastikan service quality tetap terjaga."
            )
            cost_impact = f"Tingkatkan labor cost untuk capture opportunity"
        
        return {
            "type": "staffing",
            "confidence": "high",
            "title": "Rekomendasi Pengelolaan Staff",
            "reasoning": reasoning,
            "actions": [{
                "action": action,
                "estimated_staff": staff_recommendation,
                "impact": cost_impact,
                "note": "Pertimbangkan fleksibilitas dengan staff part-time"
            }],
            "priority": "high"
        }

    def _generate_operational_insight(self, predicted, seasonal_patterns):
        """Generate operational recommendations based on peak hours"""
        today_analysis = seasonal_patterns.get('today_analysis', {})
        peak_hours = today_analysis.get('peak_hours', [])
        
        if not peak_hours:
            return None
        
        # Parse peak hours
        peak_hours_list = [int(h.split(':')[0]) for h in peak_hours]
        
        if not peak_hours_list:
            return None
        
        first_peak = peak_hours_list[0]
        last_peak = peak_hours_list[-1]
        
        if len(peak_hours_list) == 1:
            shift_recommendation = f"{first_peak}:00 - {first_peak + 3}:00"
        else:
            shift_recommendation = f"{first_peak}:00 - {last_peak + 2}:00"
        
        return {
            "type": "operational",
            "confidence": "medium",
            "title": "Optimasi Jadwal & Persiapan Operasional",
            "reasoning": (
                f"Jam-jam puncak hari ini adalah pukul {', '.join(peak_hours)}. "
                f"Konsentrasikan staff dan sumber daya pada periode tersebut untuk efisiensi maksimal."
            ),
            "actions": [{
                "action": f"Fokus peak period: {shift_recommendation}",
                "detail": f"Posisikan staff full-capacity pada jam-jam puncak",
                "preparation": "Persiapkan bahan baku dan equipment sebelum jam puncak"
            }],
            "peak_hours": peak_hours,
            "priority": "medium"
        }

    def _generate_cost_optimization_insight(self, predicted, average):
        """Generate cost optimization recommendations"""
        if average == 0:
            return None
        
        percentage_diff = ((predicted - average) / average) * 100
        
        if percentage_diff < -30:
            # Significant revenue drop
            actions = [
                {
                    "action": "Shutdown atau mini shift saja",
                    "reason": "Revenue sangat rendah, fixed cost akan mengalami deficit",
                    "detail": "Pertimbangkan untuk tidak buka atau buka dengan staff minimal saja"
                },
                {
                    "action": "Fokus pada menu dengan margin tinggi",
                    "reason": "Kurangi waste dan fokus pada profitabilitas bukan volume",
                    "detail": "Promosi menu dengan margin keuntungan terbaik"
                }
            ]
            summary = "STRATEGI DEFICIT MANAGEMENT: Revenue diprediksi jauh di bawah break-even point"
        elif percentage_diff < -10:
            actions = [
                {
                    "action": "Optimalkan labor cost",
                    "reason": "Pendapatan menurun, kurangi jam operasional jika memungkinkan",
                    "detail": "Tutup pada jam-jam yang diprediksi sepi"
                },
                {
                    "action": "Promo khusus untuk boost sales",
                    "reason": "Dorong customer acquisition untuk recovery",
                    "detail": "Tawarkan diskon atau bundle untuk meningkatkan traffic"
                }
            ]
            summary = "STRATEGI COST REDUCTION: Terapkan penghematan biaya operasional"
        elif percentage_diff > 20:
            actions = [
                {
                    "action": "Maksimalkan kapasitas",
                    "reason": "Revenue tinggi, pastikan inventory mencukupi",
                    "detail": "Stock bahan baku ekstra untuk capitalize opportunity"
                },
                {
                    "action": "Tingkatkan service quality",
                    "reason": "Tingginya demand adalah kesempatan untuk customer delight",
                    "detail": "Extra toppings, faster service, excellent presentation"
                }
            ]
            summary = "STRATEGI GROWTH: Maksimalkan keuntungan dari permintaan tinggi"
        else:
            actions = [
                {
                    "action": "Maintain status quo",
                    "reason": "Revenue dalam range normal",
                    "detail": "Pertahankan operasional standar"
                }
            ]
            summary = "STRATEGI STABLE: Revenue dalam rentang normal, maintain current operations"
        
        return {
            "type": "cost_optimization",
            "confidence": "medium",
            "title": "Optimasi Biaya & Profitabilitas",
            "summary": summary,
            "actions": actions,
            "priority": "medium"
        }

    # ========================
    # GENERAL RECOMMENDATIONS
    # ========================
    
    def get_daily_summary(self, menu_insights, revenue_insights):
        """Generate daily executive summary"""
        summary = {
            "date": datetime.now().strftime("%Y-%m-%d"),
            "total_insights": len(menu_insights) + len(revenue_insights),
            "menu_recommendations": menu_insights,
            "revenue_recommendations": revenue_insights,
            "priority_actions": self._extract_priority_actions(
                menu_insights + revenue_insights
            )
        }
        return summary

    def _extract_priority_actions(self, insights):
        """Extract top priority actions from all insights"""
        priority_actions = []
        
        for insight in insights:
            if insight.get('priority') == 'high':
                if 'actions' in insight:
                    for action in insight['actions'][:1]:  # Top 1 action per insight
                        priority_actions.append({
                            "type": insight.get('type'),
                            "title": insight.get('title'),
                            "action": action.get('action') or action if isinstance(action, str) else str(action)
                        })
        
        return priority_actions[:5]  # Top 5 priority actions
