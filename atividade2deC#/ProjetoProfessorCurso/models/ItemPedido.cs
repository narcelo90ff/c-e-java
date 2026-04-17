namespace ProjetoPedidos.Models;

public class ItemPedido
{
    public int Id { get; set; }
    public string Produto { get; set; } = string.Empty;
    public int Quantidade { get; set; }

    // ✅ Adicionado preço unitário — faz sentido em qualquer pedido real
    public decimal PrecoUnitario { get; set; }

    // Chave estrangeira
    public int PedidoId { get; set; }

    // Propriedade de navegação
    public Pedido Pedido { get; set; } = null!;
}
